<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Kpi;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class KpiFactory
{
    public function createKpi(): Kpi
    {
        $kpi = new Kpi();
        $kpi->setUuid((string) Uuid::v4());

        return $kpi;
    }

    public function createKpiWithRequired(
        int $accountCounter,
        int $accountOperationCounter,
        int $achievementCounter,
        int $completedRoutineCounter,
        int $contactCounter,
        DateTimeImmutable $date,
        int $goalCounter,
        int $noteCounter,
        int $profileCounter,
        int $projectCounter,
        int $promotionCounter,
        int $quoteCounter,
        int $reminderCounter,
        int $reminderMessageCounter,
        int $rewardCounter,
        int $routineCounter,
        int $savedEmailCounter,
        int $sentReminderCounter,
        int $userCounter,
        int $userKpiCounter
    ): Kpi {
        $kpi = $this->createKpi();

        $kpi
            ->setAccountCounter($accountCounter)
            ->setAccountOperationCounter($accountOperationCounter)
            ->setAchievementCounter($achievementCounter)
            ->setCompletedRoutineCounter($completedRoutineCounter)
            ->setContactCounter($contactCounter)
            ->setDate($date)
            ->setGoalCounter($goalCounter)
            ->setNoteCounter($noteCounter)
            ->setProfileCounter($profileCounter)
            ->setProjectCounter($projectCounter)
            ->setPromotionCounter($promotionCounter)
            ->setQuoteCounter($quoteCounter)
            ->setReminderCounter($reminderCounter)
            ->setReminderMessageCounter($reminderMessageCounter)
            ->setRewardCounter($rewardCounter)
            ->setRoutineCounter($routineCounter)
            ->setSavedEmailCounter($savedEmailCounter)
            ->setSentReminderCounter($sentReminderCounter)
            ->setUserCounter($userCounter)
            ->setUserKpiCounter($userKpiCounter);

        return $kpi;
    }
}
