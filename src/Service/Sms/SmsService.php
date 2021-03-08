<?php

declare(strict_types=1);

namespace App\Service\Sms;

class SmsService implements SmsServiceInterface
{
    public function __construct(private AmazonSnsService $amazonSnsService)
    {
    }

    public function send(string $message, string $phone): string
    {
        $result = $this->amazonSnsService->send($message, $phone);

        return $result;
    }

    public function sendPhoneVerificationCode(string $phone, array $context = []): string
    {
        $message = sprintf('Your phone verification code is %s', $context['phone_verification_code']);
        $result = $this->send($message, $phone);

        return $result;
    }

    public function sendReminderMessage(string $phone, array $context = []): string
    {
        $message = $context['sms_message'];
        $result = $this->send($message, $phone);

        return $result;
    }
}
