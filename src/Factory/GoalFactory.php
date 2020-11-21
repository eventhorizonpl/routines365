<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Goal;
use Symfony\Component\Uid\Uuid;

class GoalFactory
{
    public function createGoal(): Goal
    {
        $goal = new Goal();
        $goal->setUuid((string) Uuid::v4());

        return $goal;
    }

    public function createGoalWithRequired(
        bool $isCompleted,
        string $name
    ): Goal {
        $goal = $this->createGoal();

        $goal
            ->setIsCompleted($isCompleted)
            ->setName($name);

        return $goal;
    }
}
