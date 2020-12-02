<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Reward;
use App\Factory\RewardFactory;
use Faker\Factory;
use Faker\Generator;

class RewardFaker
{
    private Generator $faker;
    private RewardFactory $rewardFactory;

    public function __construct(
        RewardFactory $rewardFactory
    ) {
        $this->faker = Factory::create();
        $this->rewardFactory = $rewardFactory;
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
            $isAwarded = false;
        }

        if (null === $name) {
            $name = (string) $this->faker->text(64);
        }

        if (null === $numberOfCompletions) {
            $numberOfCompletions = (int) $this->faker->randomElement(
                Reward::getRequiredNumberOfCompletionsValidationChoices()
            );
        }

        if (null === $requiredNumberOfCompletions) {
            $requiredNumberOfCompletions = (int) $this->faker->randomElement(
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
}
