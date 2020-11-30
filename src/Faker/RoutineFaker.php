<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Routine;
use App\Factory\RoutineFactory;
use Faker\Factory;
use Faker\Generator;

class RoutineFaker
{
    private Generator $faker;
    private RoutineFactory $routineFactory;

    public function __construct(
        RoutineFactory $routineFactory
    ) {
        $this->faker = Factory::create();
        $this->routineFactory = $routineFactory;
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
            $type
        );

        $routine->setDescription($description);

        return $routine;
    }
}
