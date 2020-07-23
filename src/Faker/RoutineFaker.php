<?php

namespace App\Faker;

use App\Entity\Routine;
use App\Factory\RoutineFactory;
use App\Manager\RoutineManager;
use Faker\Factory;
use Faker\Generator;

class RoutineFaker
{
    private Generator $faker;
    private RoutineFactory $routineFactory;
    private RoutineManager $routineManager;

    public function __construct(
        RoutineFactory $routineFactory,
        RoutineManager $routineManager
    ) {
        $this->faker = Factory::create();
        $this->routineFactory = $routineFactory;
        $this->routineManager = $routineManager;
    }

    public function createRoutine(
        ?string $description = null,
        ?bool $isEnabled = null,
        ?string $name = null,
        ?string $type = null
    ): Routine {
        if (null === $description) {
            $description = (string) $this->faker->text;
        }

        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean;
        }

        if (null === $name) {
            $name = (string) $this->faker->word;
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Routine::getTypeFormChoices()
            );
        }

        $routine = $this->routineFactory->createRoutineWithRequired(
            $isEnabled,
            $name,
            $type,
            $description
        );

        return $routine;
    }

    public function createRoutinePersisted(
        ?string $description = null,
        ?bool $isEnabled = null,
        ?string $name = null,
        ?string $type = null
    ): Routine {
        $routine = $this->createRoutine(
            $description,
            $isEnabled,
            $name,
            $type
        );
        $this->routineManager->save($routine);

        return $routine;
    }
}
