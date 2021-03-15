<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Kpi;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class KpiManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $kpis, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($kpis as $kpi) {
            $this->save($kpi, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Kpi $kpi): self
    {
        $this->entityManager->remove($kpi);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Kpi $kpi, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $kpi->getId()) {
            $kpi->setCreatedAt($date);
        }
        $kpi->setUpdatedAt($date);

        $errors = $this->validate($kpi);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $kpi));
        }

        $this->entityManager->persist($kpi);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Kpi $kpi): self
    {
        $date = new DateTimeImmutable();
        $kpi->setDeletedAt($date);

        $this->entityManager->persist($kpi);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Kpi $kpi): self
    {
        $kpi->setDeletedAt(null);

        $this->entityManager->persist($kpi);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Kpi $kpi): ConstraintViolationListInterface
    {
        return $this->validator->validate($kpi, null, ['system']);
    }
}
