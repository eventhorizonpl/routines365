<?php

declare(strict_types=1);

namespace App\Enum;

enum SavedEmailTypeEnum: string
{
    case INVITATION = 'invitation';
    case MOTIVATIONAL = 'motivational';
}
