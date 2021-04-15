<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Achievement;
use App\Factory\AchievementFactory;
use App\Manager\AchievementManager;
use Faker\{Factory, Generator};
use Symfony\Component\Uid\Uuid;

class AchievementFaker
{
    private Generator $faker;

    public function __construct(
        private AchievementFactory $achievementFactory,
        private AchievementManager $achievementManager
    ) {
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
            $isEnabled = (bool) $this->faker->boolean();
        }

        if (null === $level) {
            $level = $this->faker->numberBetween(1, 10);
        }

        if (null === $name) {
            $name = $this->faker->sentence(1);
        }

        if (null === $requirement) {
            $requirement = $this->faker->numberBetween(1, 1000);
        }

        if (null === $type) {
            $type = $this->faker->randomElement(
                Achievement::getTypeFormChoices()
            );
        }

        return $this->achievementFactory->createAchievementWithRequired(
            $isEnabled,
            $level,
            $name,
            $requirement,
            $type
        );
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
