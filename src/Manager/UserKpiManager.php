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

    public function bulkSave(array $userKpis, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
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
        $createdAt = $userKpi->getUser()->getCreatedAt();
        $diff = $createdAt->diff($date);
        $days = ($diff->days > 0) ? $diff->days : 1;

        $efficiency11 = (int) (((($userKpi->getAwardedRewardCounter() * 1.1) +
                            ($userKpi->getCompletedGoalCounter() * 1.1) +
                            ($userKpi->getCompletedProjectCounter() * 1.1) +
                            ($userKpi->getCompletedRoutineCounter() * 1.1) +
                            ($userKpi->getNoteCounter() * 1.1) +
                            ($userKpi->getGoalCounter()) +
                            ($userKpi->getProjectCounter()) +
                            ($userKpi->getReminderCounter()) +
                            ($userKpi->getRewardCounter()) +
                            ($userKpi->getRoutineCounter())) /
                            ($days / 1.1)) *
                        1000);
        $userKpi->setEfficiency11($efficiency11);

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
