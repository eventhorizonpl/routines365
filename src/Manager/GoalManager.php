<?php

namespace App\Manager;

use App\Entity\Goal;
use App\Exception\ManagerException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GoalManager
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

    public function delete(Goal $routine): self
    {
        $this->entityManager->remove($routine);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Goal $routine, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = $routine->getUser();
        }

        $date = new DateTime();
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

    public function softDelete(Goal $routine, string $actor): self
    {
        $date = new DateTime();
        $routine->setDeletedAt($date);
        $routine->setDeletedBy($actor);

        $this->entityManager->persist($routine);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Goal $routine): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($routine, null, ['system']);

        return $errors;
    }
}
