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
    private GoalFactory $goalFactory;

    public function __construct(
        GoalFactory $goalFactory
    ) {
        $this->faker = Factory::create();
        $this->goalFactory = $goalFactory;
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
            $name = (string) $this->faker->word;
        }

        $goal = $this->goalFactory->createGoalWithRequired(
            $isCompleted,
            $name
        );

        $goal->setDescription($description);

        return $goal;
    }
}
