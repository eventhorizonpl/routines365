<?php

namespace App\Service\Sms;

class SmsService implements SmsServiceInterface
{
    private AmazonSnsService $amazonSnsService;

    public function __construct(
        AmazonSnsService $amazonSnsService
    ) {
        $this->amazonSnsService = $amazonSnsService;
    }

    public function send(string $message, string $phone): string
    {
        $result = $this->amazonSnsService->send($message, $phone);

        return $result;
    }

    public function sendPhoneVerificationCode(string $phone, array $context = []): string
    {
        $message = 'Your phone verification code is '.$context['phone_verification_code'];
        $result = $this->send($message, $phone);

        return $result;
    }
}
