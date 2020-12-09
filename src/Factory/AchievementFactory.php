<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Achievement;
use Symfony\Component\Uid\Uuid;

class AchievementFactory
{
    public function createAchievement(): Achievement
    {
        $achievement = new Achievement();
        $achievement->setUuid((string) Uuid::v4());

        return $achievement;
    }

    public function createAchievementWithRequired(
        bool $isEnabled,
        int $level,
        string $name,
        int $requirement,
        string $type
    ): Achievement {
        $achievement = $this->createAchievement();

        $achievement
            ->setIsEnabled($isEnabled)
            ->setLevel($level)
            ->setName($name)
            ->setRequirement($requirement)
            ->setType($type);

        return $achievement;
    }
}
