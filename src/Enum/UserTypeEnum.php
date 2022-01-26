<?php

declare(strict_types=1);

namespace App\Enum;

enum UserTypeEnum: string
{
    case CUSTOMER = 'customer';
    case LEAD = 'lead';
    case PROSPECT = 'prospect';
    case STAFF = 'staff';
}
