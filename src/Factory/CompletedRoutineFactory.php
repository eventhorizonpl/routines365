<?php

namespace App\Factory;

use App\Entity\CompletedRoutine;
use Symfony\Component\Uid\Uuid;

class CompletedRoutineFactory
{
    public function createCompletedRoutine(): CompletedRoutine
    {
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setUuid(Uuid::v4());

        return $completedRoutine;
    }

    public function createCompletedRoutineWithRequired(
        int $minutesDevoted
    ): CompletedRoutine {
        $completedRoutine = $this->createCompletedRoutine();

        $completedRoutine->setMinutesDevoted($minutesDevoted);

        return $completedRoutine;
    }
}
