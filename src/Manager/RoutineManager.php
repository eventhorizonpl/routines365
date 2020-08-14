<?php

namespace App\Manager;

use App\Entity\Routine;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RoutineManager
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

    public function bulkSave(array $routines, string $actor = null, int $saveEvery = 100): self
    {
        $i = 1;
        foreach ($routines as $routine) {
            $this->save($routine, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Routine $routine): self
    {
        $this->entityManager->remove($routine);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Routine $routine, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = $routine->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $routine->getId()) {
            $routine->setCreatedAt($date);
            $routine->setCreatedBy($actor);
        }
        $routine->setUpdatedAt($date);
        $routine->setUpdatedBy($actor);

        $errors = $this->validate($routine);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$routine);
        }

        $this->entityManager->persist($routine);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Routine $routine, string $actor): self
    {
        $date = new DateTimeImmutable();
        $routine->setDeletedAt($date);
        $routine->setDeletedBy($actor);

        $this->entityManager->persist($routine);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Routine $routine): self
    {
        $routine->setDeletedAt(null);
        $routine->setDeletedBy(null);

        $this->entityManager->persist($routine);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Routine $routine): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($routine, null, ['system']);

        return $errors;
    }
}
