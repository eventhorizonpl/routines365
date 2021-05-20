<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{Achievement, User};
use App\Enum\AchievementTypeEnum;
use App\Manager\UserManager;
use App\Repository\AchievementRepository;

class AchievementService
{
    public function __construct(
        private AchievementRepository $achievementRepository,
        private UserManager $userManager
    ) {
    }

    public function manageAchievements(User $user, string $type): ?Achievement
    {
        $achievement = null;
        $saveUser = false;

        if (AchievementTypeEnum::COMPLETED_ROUTINE === $type) {
            $requirement = \count($user->getCompletedRoutines());
        } elseif (AchievementTypeEnum::COMPLETED_GOAL === $type) {
            $requirement = \count($user->getGoalsCompleted());
        } elseif (AchievementTypeEnum::COMPLETED_PROJECT === $type) {
            $requirement = \count($user->getProjectsCompleted());
        } elseif (AchievementTypeEnum::CREATED_NOTE === $type) {
            $requirement = \count($user->getNotes());
        } else {
            $requirement = 10000;
        }

        $achievements = $this->achievementRepository->findByRequirementAndType($requirement, $type);

        foreach ($achievements as $achievementTmp) {
            if (false === $user->hasAchievement($achievementTmp)) {
                $user->addAchievement($achievementTmp);
                $achievement = $achievementTmp;
                $saveUser = true;
            }
        }

        if (true === $saveUser) {
            $this->userManager->save($user);
        }

        return $achievement;
    }
}
