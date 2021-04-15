<?php

declare(strict_types=1);

namespace App\Dto;

abstract class BaseRoutine
{
    /**
     * A routine description.
     */
    public ?string $description = '';

    /**
     * A routine name.
     */
    public string $name;
}
