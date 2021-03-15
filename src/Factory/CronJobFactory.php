<?php

declare(strict_types=1);

namespace App\Factory;

use Cron\CronBundle\Entity\CronJob;

class CronJobFactory
{
    public function createCronJob(): CronJob
    {
        return new CronJob();
    }

    public function createCronJobWithRequired(
        string $command,
        string $description,
        bool $enabled,
        string $name,
        string $schedule
    ): CronJob {
        $cronJob = $this->createCronJob();

        $cronJob
            ->setCommand($command)
            ->setDescription($description)
            ->setEnabled($enabled)
            ->setName($name)
            ->setSchedule($schedule)
        ;

        return $cronJob;
    }
}
