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
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $quotes, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
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

    public function incrementPopularity(Quote $quote): self
    {
        $quote->incrementPopularity();
        $this->save($quote, $quote->getUpdatedBy());

        return $this;
    }

    public function save(Quote $quote, string $actor, bool $flush = true): self
    {
        $quote->setStringLength(mb_strlen((string) $quote));
        $quote->setContentMd5($quote->getContent());

        $date = new DateTimeImmutable();
        if (null === $quote->getId()) {
            $quote->setCreatedAt($date);
            $quote->setCreatedBy($actor);
        }
        $quote->setUpdatedAt($date);
        $quote->setUpdatedBy($actor);

        $errors = $this->validate($quote);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $quote));
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
        return $this->validator->validate($quote, null, ['system']);
    }
}
