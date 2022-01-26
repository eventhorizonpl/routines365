<?php

declare(strict_types=1);

namespace App\Enum;

enum ReminderMessageTypeEnum: string
{
    case BROWSER = 'browser';
    case EMAIL = 'email';
    case SMS = 'sms';
}
