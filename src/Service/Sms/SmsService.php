<?php

namespace App\Service\Sms;

class SmsService implements SmsServiceInterface
{
    private AmazonSmsService $amazonSmsService;

    public function __construct(
        AmazonSmsService $amazonSmsService
    ) {
        $this->amazonSmsService = $amazonSmsService;
    }

    public function send(string $message, string $phone): string
    {
        $result = $this->amazonSmsService->send($message, $phone);

        return $result;
    }

    public function sendPhoneVerificationCode(string $phone, array $context = []): string
    {
        $message = 'Your phone verification code is '.$context['phone_verification_code'];
        $result = $this->send($message, $phone);

        return $result;
    }
}
