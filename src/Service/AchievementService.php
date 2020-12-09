<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Achievement;
use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\AchievementRepository;

class AchievementService
{
    private AchievementRepository $achievementRepository;
    private UserManager $userManager;

    public function __construct(
        AchievementRepository $achievementRepository,
        UserManager $userManager
    ) {
        $this->achievementRepository = $achievementRepository;
        $this->userManager = $userManager;
    }

    public function manageAchievements(User $user, string $type): ?Achievement
    {
        $achievement = null;
        $saveUser = false;

        if (Achievement::TYPE_COMPLETED_ROUTINE === $type) {
            $requirement = count($user->getCompletedRoutines());
        } elseif (Achievement::TYPE_COMPLETED_GOAL === $type) {
            $requirement = count($user->getGoalsCompleted());
        } elseif (Achievement::TYPE_COMPLETED_PROJECT === $type) {
            $requirement = count($user->getProjectsCompleted());
        } elseif (Achievement::TYPE_CREATED_NOTE === $type) {
            $requirement = count($user->getNotes());
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
