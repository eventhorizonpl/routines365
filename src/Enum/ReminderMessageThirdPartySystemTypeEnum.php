<?php

declare(strict_types=1);

namespace App\Enum;

enum ReminderMessageThirdPartySystemTypeEnum: string
{
    case AMAZON_SES = 'amazon_ses';
    case AMAZON_SNS = 'amazon_sns';
}
