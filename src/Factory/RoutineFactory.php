<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Routine;
use App\Enum\RoutineTypeEnum;
use Symfony\Component\Uid\Uuid;

class RoutineFactory
{
    public function createRoutine(): Routine
    {
        $routine = new Routine();
        $routine->setUuid((string) Uuid::v4());

        return $routine;
    }

    public function createRoutineWithRequired(
        bool $isEnabled,
        string $name,
        RoutineTypeEnum $type
    ): Routine {
        $routine = $this->createRoutine();

        $routine
            ->setIsEnabled($isEnabled)
            ->setName($name)
            ->setType($type)
        ;

        return $routine;
    }
}
