<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\CompletedRoutine;
use App\Factory\CompletedRoutineFactory;
use App\Manager\CompletedRoutineManager;
use Faker\Factory;
use Faker\Generator;

class CompletedRoutineFaker
{
    private CompletedRoutineFactory $completedRoutineFactory;
    private CompletedRoutineManager $completedRoutineManager;
    private Generator $faker;

    public function __construct(
        CompletedRoutineFactory $completedRoutineFactory,
        CompletedRoutineManager $completedRoutineManager
    ) {
        $this->faker = Factory::create();
        $this->completedRoutineFactory = $completedRoutineFactory;
        $this->completedRoutineManager = $completedRoutineManager;
    }

    public function createCompletedRoutine(
        ?string $comment = null,
        ?int $minutesDevoted = null
    ): CompletedRoutine {
        if (null === $comment) {
            $comment = (string) $this->faker->text;
        }

        if (null === $minutesDevoted) {
            $minutesDevoted = (int) $this->faker->randomNumber(2);
        }

        $completedRoutine = $this->completedRoutineFactory->createCompletedRoutineWithRequired(
            $minutesDevoted
        );

        $completedRoutine->setComment($comment);

        return $completedRoutine;
    }

    public function createCompletedRoutinePersisted(
        ?string $comment = null,
        ?int $minutesDevoted = null
    ): CompletedRoutine {
        $completedRoutine = $this->createCompletedRoutine(
            $comment,
            $minutesDevoted
        );
        $this->completedRoutineManager->save($completedRoutine);

        return $completedRoutine;
    }
}
