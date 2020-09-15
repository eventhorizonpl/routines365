<?php

namespace App\Service\Sms;

interface SmsServiceInterface
{
    public function send(string $message, string $phone): string;
}
