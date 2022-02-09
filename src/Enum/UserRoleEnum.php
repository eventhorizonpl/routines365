<?php

declare(strict_types=1);

namespace App\Enum;

enum UserRoleEnum: string
{
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    case ROLE_USER = 'ROLE_USER';
}
