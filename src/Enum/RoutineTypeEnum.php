<?php

declare(strict_types=1);

namespace App\Enum;

enum RoutineTypeEnum: string
{
    case HOBBY = 'hobby';
    case LEARNING = 'learning';
    case SPORT = 'sport';
    case WORK = 'work';
}
