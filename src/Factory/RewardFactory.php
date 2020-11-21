<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Reward;
use Symfony\Component\Uid\Uuid;

class RewardFactory
{
    public function createReward(): Reward
    {
        $reward = new Reward();
        $reward->setUuid((string) Uuid::v4());

        return $reward;
    }

    public function createRewardWithRequired(
        bool $isAwarded,
        string $name,
        int $requiredNumberOfCompletions,
        string $type
    ): Reward {
        $reward = $this->createReward();

        $reward
            ->setIsAwarded($isAwarded)
            ->setName($name)
            ->setRequiredNumberOfCompletions($requiredNumberOfCompletions)
            ->setType($type);

        return $reward;
    }
}
