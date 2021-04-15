<?php

declare(strict_types=1);

namespace App\Dto;

final class NoteCollectionOutput extends BaseNote
{
    /**
     * A note uuid.
     */
    public string $uuid;
}
