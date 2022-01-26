<?php

declare(strict_types=1);

namespace App\Enum;

enum ReminderTypeEnum: string
{
    case DAILY = 'daily';
    case FRIDAY = 'friday';
    case MONDAY = 'monday';
    case SATURDAY = 'saturday';
    case SUNDAY = 'sunday';
    case THURSDAY = 'thursday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
}
