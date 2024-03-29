<?php

declare(strict_types=1);

namespace App\Resource;

class ConfigResource
{
    public const ACCOUNT_AVAILABLE_NOTIFICATIONS_LIMIT = 2000;
    public const ACCOUNT_AVAILABLE_SMS_NOTIFICATIONS_LIMIT = 200;
    public const COUNTRIES_ALLOWED_FOR_SMS = ['PL', 'US'];
    public const INVITATIONS_ENABLED = true;
    public const MOTIVATE_A_FRIEND_ENABLED = true;
    public const NOTIFICATION_BROWSER_ENABLED = false;
    public const NOTIFICATION_SMS_ENABLED = false;
    public const PROMOTIONS_ENABLED = true;
    public const REGISTRATION_ENABLED = true;
}
