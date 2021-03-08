<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Goal;
use App\Factory\GoalFactory;
use Faker\Factory;
use Faker\Generator;

class GoalFaker
{
    private Generator $faker;

    public function __construct(
        private GoalFactory $goalFactory
    ) {
        $this->faker = Factory::create();
    }

    public function createGoal(
        ?string $description = null,
        ?bool $isCompleted = null,
        ?string $name = null
    ): Goal {
        if (null === $description) {
            $description = (string) $this->faker->text;
        }

        if (null === $isCompleted) {
            $isCompleted = (bool) $this->faker->boolean;
        }

        if (null === $name) {
            $name = (string) $this->faker->text(64);
        }

        $goal = $this->goalFactory->createGoalWithRequired(
            $isCompleted,
            $name
        );

        $goal->setDescription($description);

        return $goal;
    }
}
