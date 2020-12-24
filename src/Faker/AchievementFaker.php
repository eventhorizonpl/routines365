<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Achievement;
use App\Factory\AchievementFactory;
use App\Manager\AchievementManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class AchievementFaker
{
    private AchievementFactory $achievementFactory;
    private AchievementManager $achievementManager;
    private Generator $faker;

    public function __construct(
        AchievementFactory $achievementFactory,
        AchievementManager $achievementManager
    ) {
        $this->achievementFactory = $achievementFactory;
        $this->achievementManager = $achievementManager;
        $this->faker = Factory::create();
    }

    public function createAchievement(
        ?bool $isEnabled = null,
        ?int $level = null,
        ?string $name = null,
        ?int $requirement = null,
        ?string $type = null
    ): Achievement {
        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean;
        }

        if (null === $level) {
            $level = $this->faker->numberBetween(1, 10);
        }

        if (null === $name) {
            $name = $this->faker->sentence(5);
        }

        if (null === $requirement) {
            $requirement = $this->faker->numberBetween(1, 1000);
        }

        if (null === $type) {
            $type = $this->faker->randomElement(
                Achievement::getTypeFormChoices()
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

    public function createAchievementPersisted(
        ?bool $isEnabled = null,
        ?int $level = null,
        ?string $name = null,
        ?int $requirement = null,
        ?string $type = null
    ): Achievement {
        $achievement = $this->createAchievement(
            $isEnabled,
            $level,
            $name,
            $requirement,
            $type
        );
        $this->achievementManager->save($achievement, (string) Uuid::v4());

        return $achievement;
    }
}
