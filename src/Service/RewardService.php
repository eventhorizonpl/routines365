<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{Reward, Routine};
use App\Enum\RewardTypeEnum;
use App\Manager\RewardManager;
use App\Repository\RewardRepository;

class RewardService
{
    public function __construct(
        private RewardManager $rewardManager,
        private RewardRepository $rewardRepository
    ) {
    }

    public function findReward(Routine $routine, string $type): ?Reward
    {
        $user = $routine->getUser();
        $types = [
            RewardTypeEnum::ALL,
            $type,
        ];
        $reward = $this->rewardRepository->findOneByUserAndTypesAndRoutine($user, $types, $routine);

        if (null === $reward) {
            $reward = $this->rewardRepository->findOneByUserAndTypesAndRoutine($user, $types);
        }

        return $reward;
    }

    public function manageReward(Routine $routine, string $type): ?Reward
    {
        $reward = $this->findReward($routine, $type);

        if (null !== $reward) {
            $reward->incrementNumberOfCompletions();
            $this->rewardManager->save($reward);
        }

        return $reward;
    }
}
