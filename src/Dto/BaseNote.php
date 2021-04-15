<?php

declare(strict_types=1);

namespace App\Dto;

abstract class BaseNote
{
    /**
     * A note content.
     */
    public string $content;

    /**
     * A note routine.
     */
    public ?string $routine = null;

    /**
     * A note title.
     */
    public string $title;
}
