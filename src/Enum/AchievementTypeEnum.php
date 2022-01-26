<?php

declare(strict_types=1);

namespace App\Enum;

enum AchievementTypeEnum: string
{
    case COMPLETED_ROUTINE = 'completed_routine';
    case COMPLETED_GOAL = 'completed_goal';
    case COMPLETED_PROJECT = 'completed_project';
    case CREATED_NOTE = 'created_note';
}
