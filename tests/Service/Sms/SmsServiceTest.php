<?php

declare(strict_types=1);

namespace App\Tests\Service\Sms;

use App\Service\Sms\{AmazonSnsService, SmsService};
use App\Tests\AbstractDoctrineTestCase;
use AsyncAws\Core\Exception\Http\NetworkException;

/**
 * @internal
 * @coversNothing
 */
final class SmsServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AmazonSnsService $amazonSnsService;
    /**
     * @inject
     */
    private ?SmsService $smsService;

    protected function tearDown(): void
    {
        $this->amazonSnsService = null;
        $this->smsService = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $smsService = new SmsService($this->amazonSnsService);

        $this->assertInstanceOf(SmsService::class, $smsService);
    }

    public function testSend(): void
    {
        $this->expectException(NetworkException::class);
        $result = $this->smsService->send('test message', '+48881573056');
    }

    public function testSendPhoneVerificationCode(): void
    {
        $this->expectException(NetworkException::class);
        $result = $this->smsService->sendPhoneVerificationCode(
            '+48881573056',
            [
                'phone_verification_code' => 'test phone_verification_code',
            ]
        );
    }

    public function testSendReminderMessage(): void
    {
        $this->expectException(NetworkException::class);
        $result = $this->smsService->sendReminderMessage(
            '+48881573056',
            [
                'sms_message' => 'test sms_message',
            ]
        );
    }
}
