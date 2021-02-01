<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Report;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReportManager
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

    public function bulkSave(array $reports, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($reports as $report) {
            $this->save($report, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Report $report): self
    {
        $this->entityManager->remove($report);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Report $report, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $report->getId()) {
            $report->setCreatedAt($date);
        }
        $report->setUpdatedAt($date);

        $errors = $this->validate($report);
        if (0 !== count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $report));
        }

        $this->entityManager->persist($report);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Report $report): self
    {
        $date = new DateTimeImmutable();
        $report->setDeletedAt($date);

        $this->entityManager->persist($report);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Report $report): self
    {
        $report->setDeletedAt(null);

        $this->entityManager->persist($report);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Report $report): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($report, null, ['system']);

        return $errors;
    }
}
