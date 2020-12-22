<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\UserKpi;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserKpiManager
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

    public function bulkSave(array $userKpis, int $saveEvery = 100): self
    {
        $i = 1;
        foreach ($userKpis as $userKpi) {
            $this->save($userKpi, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(UserKpi $userKpi): self
    {
        $this->entityManager->remove($userKpi);
        $this->entityManager->flush();

        return $this;
    }

    public function save(UserKpi $userKpi, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $userKpi->getId()) {
            $userKpi->setCreatedAt($date);
        }
        $userKpi->setUpdatedAt($date);

        $errors = $this->validate($userKpi);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$userKpi);
        }

        $this->entityManager->persist($userKpi);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(UserKpi $userKpi): self
    {
        $date = new DateTimeImmutable();
        $userKpi->setDeletedAt($date);

        $this->entityManager->persist($userKpi);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(UserKpi $userKpi): self
    {
        $userKpi->setDeletedAt(null);

        $this->entityManager->persist($userKpi);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(UserKpi $userKpi): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($userKpi, null, ['system']);

        return $errors;
    }
}
