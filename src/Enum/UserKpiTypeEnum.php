<?php

declare(strict_types=1);

namespace App\Enum;

enum UserKpiTypeEnum: string
{
    case ANNUALLY = 'annually';
    case DAILY = 'daily';
    case MONTHLY = 'monthly';
    case WEEKLY = 'weekly';
}
