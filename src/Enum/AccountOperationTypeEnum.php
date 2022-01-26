<?php

declare(strict_types=1);

namespace App\Enum;

enum AccountOperationTypeEnum: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
}
