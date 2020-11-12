<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Reward;
use App\Factory\RewardFactory;
use App\Manager\RewardManager;
use Faker\Factory;
use Faker\Generator;

class RewardFaker
{
    private Generator $faker;
    private RewardFactory $rewardFactory;
    private RewardManager $rewardManager;

    public function __construct(
        RewardFactory $rewardFactory,
        RewardManager $rewardManager
    ) {
        $this->faker = Factory::create();
        $this->rewardFactory = $rewardFactory;
        $this->rewardManager = $rewardManager;
    }

    public function createReward(
        ?string $description = null,
        ?bool $isAwarded = null,
        ?string $name = null,
        ?int $numberOfCompletions = null,
        ?int $requiredNumberOfCompletions = null,
        ?string $type = null
    ): Reward {
        if (null === $description) {
            $description = (string) $this->faker->text;
        }

        if (null === $isAwarded) {
            $isAwarded = (bool) $this->faker->boolean;
        }

        if (null === $name) {
            $name = (string) $this->faker->word;
        }

        if (null === $numberOfCompletions) {
            $numberOfCompletions = (string) $this->faker->randomElement(
                Reward::getRequiredNumberOfCompletionsValidationChoices()
            );
        }

        if (null === $requiredNumberOfCompletions) {
            $requiredNumberOfCompletions = (string) $this->faker->randomElement(
                Reward::getRequiredNumberOfCompletionsValidationChoices()
            );
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Reward::getTypeValidationChoices()
            );
        }

        $reward = $this->rewardFactory->createRewardWithRequired(
            $isAwarded,
            $name,
            $requiredNumberOfCompletions,
            $type
        );

        $reward->setDescription($description);
        $reward->setNumberOfCompletions($numberOfCompletions);

        return $reward;
    }

    public function createRewardPersisted(
        ?string $description = null,
        ?bool $isAwarded = null,
        ?string $name = null,
        ?int $numberOfCompletions = null,
        ?int $requiredNumberOfCompletions = null,
        ?string $type = null
    ): Reward {
        $reward = $this->createReward(
            $description,
            $isAwarded,
            $name,
            $numberOfCompletions,
            $requiredNumberOfCompletions,
            $type
        );
        $this->rewardManager->save($reward);

        return $reward;
    }
}
