<?php

declare(strict_types=1);

namespace App\Dto;

abstract class BaseQuote
{
    /**
     * A quote uuid.
     */
    public string $uuid;

    /**
     * A quote author.
     */
    public string $author;

    /**
     * A quote content.
     */
    public string $content;
}
