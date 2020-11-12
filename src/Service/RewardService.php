<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Reward;
use App\Entity\Routine;
use App\Manager\RewardManager;
use App\Repository\RewardRepository;

class RewardService
{
    private RewardManager $rewardManager;
    private RewardRepository $rewardRepository;

    public function __construct(
        RewardManager $rewardManager,
        RewardRepository $rewardRepository
    ) {
        $this->rewardManager = $rewardManager;
        $this->rewardRepository = $rewardRepository;
    }

    public function findReward(Routine $routine, string $type): ?Reward
    {
        $user = $routine->getUser();
        $types = [
            Reward::TYPE_ALL,
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
