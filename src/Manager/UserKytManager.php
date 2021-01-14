<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\UserKyt;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserKytManager
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

    public function bulkSave(array $userKyts, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($userKyts as $userKyt) {
            $this->save($userKyt, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(UserKyt $userKyt): self
    {
        $this->entityManager->remove($userKyt);
        $this->entityManager->flush();

        return $this;
    }

    public function save(UserKyt $userKyt, string $actor, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $userKyt->getId()) {
            $userKyt->setCreatedAt($date);
            $userKyt->setCreatedBy($actor);
        }
        $userKyt->setUpdatedAt($date);
        $userKyt->setUpdatedBy($actor);

        $errors = $this->validate($userKyt);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$userKyt);
        }

        $this->entityManager->persist($userKyt);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(UserKyt $userKyt, string $actor): self
    {
        $date = new DateTimeImmutable();
        $userKyt->setDeletedAt($date);
        $userKyt->setDeletedBy($actor);

        $this->entityManager->persist($userKyt);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(UserKyt $userKyt): self
    {
        $userKyt->setDeletedAt(null);
        $userKyt->setDeletedBy(null);

        $this->entityManager->persist($userKyt);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(UserKyt $userKyt): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($userKyt);

        return $errors;
    }
}
