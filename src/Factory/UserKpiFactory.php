<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\UserKpi;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class UserKpiFactory
{
    public function createUserKpi(): UserKpi
    {
        $userUserKpi = new UserKpi();
        $userUserKpi->setUuid((string) Uuid::v4());

        return $userUserKpi;
    }

    public function createUserKpiWithRequired(
        int $accountOperationCounter,
        int $awardedRewardCounter,
        int $completedGoalCounter,
        int $completedProjectCounter,
        int $completedRoutineCounter,
        int $contactCounter,
        DateTimeImmutable $date,
        int $goalCounter,
        int $noteCounter,
        int $projectCounter,
        int $reminderCounter,
        int $rewardCounter,
        int $routineCounter,
        int $savedEmailCounter,
        string $type
    ): UserKpi {
        $userUserKpi = $this->createUserKpi();

        $userUserKpi
            ->setAccountOperationCounter($accountOperationCounter)
            ->setAwardedRewardCounter($awardedRewardCounter)
            ->setCompletedGoalCounter($completedGoalCounter)
            ->setCompletedProjectCounter($completedProjectCounter)
            ->setCompletedRoutineCounter($completedRoutineCounter)
            ->setContactCounter($contactCounter)
            ->setDate($date)
            ->setGoalCounter($goalCounter)
            ->setNoteCounter($noteCounter)
            ->setProjectCounter($projectCounter)
            ->setReminderCounter($reminderCounter)
            ->setRewardCounter($rewardCounter)
            ->setRoutineCounter($routineCounter)
            ->setSavedEmailCounter($savedEmailCounter)
            ->setType($type);

        return $userUserKpi;
    }
}
