<?php

namespace App;

class Config
{
    public const ACCOUNT_AVAILABLE_EMAIL_NOTIFICATIONS_LIMIT = 2000;
    public const ACCOUNT_AVAILABLE_SMS_NOTIFICATIONS_LIMIT = 200;
    public const COUNTRIES_ALLOWED_FOR_SMS = ['PL', 'US'];
    public const INVITATIONS_ENABLED = true;
    public const REGISTRATION_ENABLED = true;
}
