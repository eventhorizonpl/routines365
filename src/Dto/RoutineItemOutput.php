<?php

declare(strict_types=1);

namespace App\Dto;

final class RoutineItemOutput extends BaseRoutine
{
    /**
     * A routine uuid.
     */
    public string $uuid;

    /**
     * A routine type.
     */
    public string $type;
}
