<?php

declare(strict_types=1);

namespace App\Dto;

class RoutineCollectionInput extends BaseRoutine
{
    /**
     * A routine is enabled.
     */
    public ?bool $isEnabled = true;

    /**
     * A routine type.
     */
    public string $type;
}
