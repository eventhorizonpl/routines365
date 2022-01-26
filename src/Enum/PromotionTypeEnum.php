<?php

declare(strict_types=1);

namespace App\Enum;

enum PromotionTypeEnum: string
{
    case EXISTING_ACCOUNT = 'existing_account';
    case NEW_ACCOUNT = 'new_account';
    case SYSTEM = 'system';
}
