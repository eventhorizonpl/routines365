<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Achievement;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AchievementManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $achievements, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($achievements as $achievement) {
            $this->save($achievement, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Achievement $achievement): self
    {
        $this->entityManager->remove($achievement);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Achievement $achievement, string $actor, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $achievement->getId()) {
            $achievement->setCreatedAt($date);
            $achievement->setCreatedBy($actor);
        }
        $achievement->setUpdatedAt($date);
        $achievement->setUpdatedBy($actor);

        $errors = $this->validate($achievement);
        if (0 !== count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $achievement));
        }

        $this->entityManager->persist($achievement);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Achievement $achievement, string $actor): self
    {
        $date = new DateTimeImmutable();
        $achievement->setDeletedAt($date);
        $achievement->setDeletedBy($actor);

        $this->entityManager->persist($achievement);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Achievement $achievement): self
    {
        $achievement->setDeletedAt(null);
        $achievement->setDeletedBy(null);

        $this->entityManager->persist($achievement);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Achievement $achievement): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($achievement, null, ['system']);

        return $errors;
    }
}
