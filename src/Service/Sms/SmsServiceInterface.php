<?php

declare(strict_types=1);

namespace App\Service\Sms;

interface SmsServiceInterface
{
    public function send(string $message, string $phone): string;
}
