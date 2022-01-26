<?php

declare(strict_types=1);

namespace App\Enum;

enum RewardTypeEnum: string
{
    case ALL = 'all';
    case COMPLETED_ROUTINE = 'completed_routine';
    case COMPLETED_GOAL = 'completed_goal';
}
