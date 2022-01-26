<?php

declare(strict_types=1);

namespace App\Enum;

enum TestimonialStatusEnum: string
{
    case ACCEPTED = 'accepted';
    case NEW = 'new';
    case REJECTED = 'rejected';
}
