<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Routine;
use App\Enum\RoutineTypeEnum;
use App\Factory\RoutineFactory;
use Faker\{Factory, Generator};

class RoutineFaker
{
    private Generator $faker;

    public function __construct(
        private RoutineFactory $routineFactory
    ) {
        $this->faker = Factory::create();
    }

    public function createRoutine(
        ?string $description = null,
        ?bool $isEnabled = null,
        ?string $name = null,
        ?RoutineTypeEnum $type = null
    ): Routine {
        if (null === $description) {
            $description = (string) $this->faker->text();
        }

        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean();
        }

        if (null === $name) {
            $name = (string) $this->faker->text(64);
        }

        if (null === $type) {
            $type = RoutineTypeEnum::HOBBY;
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
