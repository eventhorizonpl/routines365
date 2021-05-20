<?php

declare(strict_types=1);

namespace App\Enum;

class ContactStatusEnum
{
    public const CLOSED = 'closed';
    public const ON_HOLD = 'on_hold';
    public const OPEN = 'open';
    public const PENDING = 'pending';
    public const SOLVED = 'solved';
    public const SPAM = 'spam';
}
