<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Achievement;
use App\Factory\AchievementFactory;
use Faker\Factory;
use Faker\Generator;

class AchievementFaker
{
    private Generator $faker;
    private AchievementFactory $achievementFactory;

    public function __construct(
        AchievementFactory $achievementFactory
    ) {
        $this->faker = Factory::create();
        $this->achievementFactory = $achievementFactory;
    }

    public function createAchievement(
        ?bool $isEnabled = null,
        ?int $level = null,
        ?string $name = null,
        ?int $requirement = null,
        ?string $type = null
    ): Achievement {
        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->bool;
        }

        if (null === $level) {
            $level = (int) $this->faker->numberBetween(1, 10);
        }

        if (null === $name) {
            $name = (string) $this->faker->text(64);
        }

        if (null === $requirement) {
            $requirement = (int) $this->faker->numberBetween(10, 1000);
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Achievement::getTypeValidationChoices()
            );
        }

        $achievement = $this->achievementFactory->createAchievementWithRequired(
            $isEnabled,
            $level,
            $name,
            $requirement,
            $type
        );

        return $achievement;
    }
}
