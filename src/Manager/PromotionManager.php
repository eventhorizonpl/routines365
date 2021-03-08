<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Promotion;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PromotionManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $promotions, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($promotions as $promotion) {
            $this->save($promotion, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Promotion $promotion): self
    {
        $this->entityManager->remove($promotion);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Promotion $promotion, string $actor, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $promotion->getId()) {
            $promotion->setCreatedAt($date);
            $promotion->setCreatedBy($actor);
        }
        $promotion->setUpdatedAt($date);
        $promotion->setUpdatedBy($actor);

        $errors = $this->validate($promotion);
        if (0 !== count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $promotion));
        }

        $this->entityManager->persist($promotion);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Promotion $promotion, string $actor): self
    {
        $date = new DateTimeImmutable();
        $promotion->setDeletedAt($date);
        $promotion->setDeletedBy($actor);

        $this->entityManager->persist($promotion);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Promotion $promotion): self
    {
        $promotion->setDeletedAt(null);
        $promotion->setDeletedBy(null);

        $this->entityManager->persist($promotion);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Promotion $promotion): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($promotion, null, ['system']);

        return $errors;
    }
}
