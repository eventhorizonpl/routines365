<?php

declare(strict_types=1);

namespace App\Enum;

enum ContactStatusEnum: string
{
    case CLOSED = 'closed';
    case ON_HOLD = 'on_hold';
    case OPEN = 'open';
    case PENDING = 'pending';
    case SOLVED = 'solved';
    case SPAM = 'spam';
}
