<?php

declare(strict_types=1);

namespace App\Manager;

use App\Exception\ManagerException;
use Cron\CronBundle\Entity\CronJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CronJobManager
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

    public function bulkSave(array $cronJobs, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($cronJobs as $cronJob) {
            $this->save($cronJob, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(CronJob $cronJob): self
    {
        $this->entityManager->remove($cronJob);
        $this->entityManager->flush();

        return $this;
    }

    public function save(CronJob $cronJob, bool $flush = true): self
    {
        $errors = $this->validate($cronJob);
        if (0 !== count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $cronJob));
        }

        $this->entityManager->persist($cronJob);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function validate(CronJob $cronJob): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($cronJob);

        return $errors;
    }
}
