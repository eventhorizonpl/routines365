<?php

declare(strict_types=1);

namespace App\Manager;

use Cron\CronBundle\Entity\CronJob;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CronJobManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
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
        $this->entityManager->persist($cronJob);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }
}
