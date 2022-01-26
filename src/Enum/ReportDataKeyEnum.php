<?php

declare(strict_types=1);

namespace App\Enum;

enum ReportDataKeyEnum: string
{
    case CREATE_SENT_REMINDER = 'create_sent_reminder';
    case REMINDER = 'reminder';
    case REMINDER_MESSAGE = 'reminder_message';
    case SENT_REMINDER = 'sent_reminder';
}
