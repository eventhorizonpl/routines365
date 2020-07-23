<?php

namespace App\Factory;

use App\Entity\Routine;
use Symfony\Component\Uid\Uuid;

class RoutineFactory
{
    public function createRoutine(): Routine
    {
        $routine = new Routine();
        $routine->setUuid(Uuid::v4());

        return $routine;
    }

    public function createRoutineWithRequired(
        bool $isEnabled,
        string $name,
        string $type,
        string $description = null
    ): Routine {
        $routine = $this->createRoutine();

        $routine->setIsEnabled($isEnabled);
        $routine->setName($name);
        $routine->setType($type);

        if (null !== $description) {
            $routine->setDescription($description);
        }

        return $routine;
    }
}
