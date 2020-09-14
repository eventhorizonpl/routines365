<?php

namespace App\Factory;

use App\Entity\Kpi;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class KpiFactory
{
    public function createKpi(): Kpi
    {
        $kpi = new Kpi();
        $kpi->setUuid(Uuid::v4());

        return $kpi;
    }

    public function createKpiWithRequired(
        int $accountCounter,
        int $accountOperationCounter,
        DateTimeImmutable $date,
        int $goalCounter,
        int $noteCounter,
        int $profileCounter,
        int $quoteCounter,
        int $reminderCounter,
        int $reminderMessageCounter,
        int $routineCounter,
        int $sentReminderCounter,
        int $userCounter
    ): Kpi {
        $kpi = $this->createKpi();

        $kpi
            ->setAccountCounter($accountCounter)
            ->setAccountOperationCounter($accountOperationCounter)
            ->setDate($date)
            ->setGoalCounter($goalCounter)
            ->setNoteCounter($noteCounter)
            ->setProfileCounter($profileCounter)
            ->setQuoteCounter($quoteCounter)
            ->setReminderCounter($reminderCounter)
            ->setReminderMessageCounter($reminderMessageCounter)
            ->setRoutineCounter($routineCounter)
            ->setSentReminderCounter($sentReminderCounter)
            ->setUserCounter($userCounter);

        return $kpi;
    }
}
