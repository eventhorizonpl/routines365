<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\CompletedRoutine;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CompletedRoutineManager
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

    public function bulkSave(array $completedRoutines, string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($completedRoutines as $completedRoutine) {
            $this->save($completedRoutine, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(CompletedRoutine $completedRoutine): self
    {
        $this->entityManager->remove($completedRoutine);
        $this->entityManager->flush();

        return $this;
    }

    public function save(CompletedRoutine $completedRoutine, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $completedRoutine->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $completedRoutine->getId()) {
            $completedRoutine->setCreatedAt($date);
            $completedRoutine->setCreatedBy($actor);
        }
        $completedRoutine->setUpdatedAt($date);
        $completedRoutine->setUpdatedBy($actor);

        $errors = $this->validate($completedRoutine);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$completedRoutine);
        }

        $this->entityManager->persist($completedRoutine);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(CompletedRoutine $completedRoutine, string $actor): self
    {
        $date = new DateTimeImmutable();
        $completedRoutine->setDeletedAt($date);
        $completedRoutine->setDeletedBy($actor);

        $this->entityManager->persist($completedRoutine);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(CompletedRoutine $completedRoutine): self
    {
        $completedRoutine->setDeletedAt(null);
        $completedRoutine->setDeletedBy(null);

        $this->entityManager->persist($completedRoutine);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(CompletedRoutine $completedRoutine): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($completedRoutine, null, ['system']);

        return $errors;
    }
}
