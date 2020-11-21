<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Quote;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuoteManager
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function bulkSave(array $quotes, string $actor, int $saveEvery = 100): self
    {
        $i = 1;
        foreach ($quotes as $quote) {
            $this->save($quote, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Quote $quote): self
    {
        $this->entityManager->remove($quote);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Quote $quote, string $actor, bool $flush = true): self
    {
        $quote->setStringLength(mb_strlen((string) $quote));
        $quote->setContentMd5($quote->getContent());

        $date = new DateTimeImmutable();
        if (null === $quote->getId()) {
            $quote->setCreatedAt($date);
            $quote->setCreatedBy((string) $actor);
        }
        $quote->setUpdatedAt($date);
        $quote->setUpdatedBy((string) $actor);

        $errors = $this->validate($quote);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$quote);
        }

        $this->entityManager->persist($quote);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Quote $quote, string $actor): self
    {
        $date = new DateTimeImmutable();
        $quote->setDeletedAt($date);
        $quote->setDeletedBy($actor);

        $this->entityManager->persist($quote);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Quote $quote): self
    {
        $quote->setDeletedAt(null);
        $quote->setDeletedBy(null);

        $this->entityManager->persist($quote);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Quote $quote): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($quote, null, ['system']);

        return $errors;
    }
}
