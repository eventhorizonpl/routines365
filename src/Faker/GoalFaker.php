<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Goal;
use App\Factory\GoalFactory;
use App\Manager\GoalManager;
use Faker\Factory;
use Faker\Generator;

class GoalFaker
{
    private Generator $faker;
    private GoalFactory $goalFactory;
    private GoalManager $goalManager;

    public function __construct(
        GoalFactory $goalFactory,
        GoalManager $goalManager
    ) {
        $this->faker = Factory::create();
        $this->goalFactory = $goalFactory;
        $this->goalManager = $goalManager;
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

    public function createGoalPersisted(
        ?string $description = null,
        ?bool $isCompleted = null,
        ?string $name = null
    ): Goal {
        $goal = $this->createGoal(
            $description,
            $isCompleted,
            $name
        );
        $this->goalManager->save($goal);

        return $goal;
    }
}
