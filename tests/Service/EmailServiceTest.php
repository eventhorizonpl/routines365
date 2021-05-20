<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Enum\UserKpiTypeEnum;
use App\Factory\UserKpiFactory;
use App\Service\EmailService;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @internal
 */
final class EmailServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?EmailService $emailService;
    /**
     * @inject
     */
    private ?UserKpiFactory $userKpiFactory;

    protected function tearDown(): void
    {
        $this->emailService = null;
        $this->userKpiFactory = null
        ;

        parent::tearDown();
    }

    public function testPrepare(): void
    {
        $templatedEmail = $this->emailService->prepare(
            'test@example.org',
            'test subject',
            'email/completed_routine_congratulations.html.twig',
            'email/completed_routine_congratulations.txt.twig',
            [
                'reminder' => null,
                'quote' => 'test quote',
            ]
        );

        $this->assertInstanceOf(TemplatedEmail::class, $templatedEmail);
    }

    public function testSend(): void
    {
        $templatedEmail = $this->emailService->prepare(
            'test@example.org',
            'test subject',
            'email/completed_routine_congratulations.html.twig',
            'email/completed_routine_congratulations.txt.twig',
            [
                'reminder' => null,
                'quote' => 'test quote',
            ]
        );

        $result = $this->emailService->send($templatedEmail);

        $this->assertFalse($result);
    }

    public function testSendCompletedRoutineCongratulations(): void
    {
        $result = $this->emailService->sendCompletedRoutineCongratulations(
            'test@example.org',
            'test subject',
            [
                'reminder' => null,
                'quote' => 'test quote',
            ]
        );

        $this->assertFalse($result);
    }

    public function testSendConfirmation(): void
    {
        $result = $this->emailService->sendConfirmation(
            'test@example.org',
            'test subject',
            [
                'signed_url' => 'test signed_url',
                'expires_at' => new DateTimeImmutable(),
            ]
        );

        $this->assertFalse($result);
    }

    public function testSendContactRequest(): void
    {
        $result = $this->emailService->sendContactRequest(
            'test@example.org',
            'test subject',
            [
                'from_email' => 'test from_email',
                'type' => 'test type',
                'title' => 'test title',
                'content' => 'test content',
            ]
        );

        $this->assertFalse($result);
    }

    public function testSendInvitation(): void
    {
        $result = $this->emailService->sendInvitation(
            'test@example.org',
            'test subject',
            [
                'first_name' => 'test first_name',
                'last_name' => 'test last_name',
                'promotion' => null,
                'referrer_code' => 'test referrer_code',
            ]
        );

        $this->assertFalse($result);
    }

    public function testSendMotivational(): void
    {
        $result = $this->emailService->sendMotivational(
            'test@example.org',
            'test subject',
            [
                'first_name' => 'test first_name',
                'last_name' => 'test last_name',
                'quote' => 'test quote',
            ]
        );

        $this->assertFalse($result);
    }

    public function testSendNewLead(): void
    {
        $result = $this->emailService->sendNewLead(
            'test@example.org',
            'test subject',
            [
                'email_address' => 'test email_address',
                'password' => 'test password',
            ]
        );

        $this->assertFalse($result);
    }

    public function testSendReminderMessage(): void
    {
        $result = $this->emailService->sendReminderMessage(
            'test@example.org',
            'test subject',
            [
                'email_original_message' => 'test email_original_message',
                'email_quote' => 'test email_quote',
                'email_link' => 'test email_link',
                'available_email_notifications' => 'test available_email_notifications',
                'available_sms_notifications' => 'test available_sms_notifications',
            ]
        );

        $this->assertFalse($result);
    }

    public function testSendRequestForTestimonial(): void
    {
        $result = $this->emailService->sendRequestForTestimonial(
            'test@example.org',
            'test subject'
        );

        $this->assertFalse($result);
    }

    public function testSendResetPassword(): void
    {
        $result = $this->emailService->sendResetPassword(
            'test@example.org',
            'test subject',
            [
                'reset_token' => [
                    'token' => 'test token',
                ],
                'token_lifetime' => new DateTimeImmutable(),
            ]
        );

        $this->assertFalse($result);
    }

    public function testSendUserKpi(): void
    {
        $userKpi = $this->userKpiFactory->createUserKpi();
        $userKpi->setType(UserKpiTypeEnum::DAILY);
        $result = $this->emailService->sendUserKpi(
            'test@example.org',
            'test subject',
            [
                'user_kpi' => $userKpi,
            ]
        );

        $this->assertFalse($result);
    }

    public function testSendUserKytBasicConfiguration(): void
    {
        $result = $this->emailService->sendUserKytBasicConfiguration(
            'test@example.org',
            'test subject'
        );

        $this->assertFalse($result);
    }

    public function testSendUserKytCompletingRoutines(): void
    {
        $result = $this->emailService->sendUserKytCompletingRoutines(
            'test@example.org',
            'test subject'
        );

        $this->assertFalse($result);
    }

    public function testSendUserKytGoals(): void
    {
        $result = $this->emailService->sendUserKytGoals(
            'test@example.org',
            'test subject'
        );

        $this->assertFalse($result);
    }

    public function testSendUserKytNotes(): void
    {
        $result = $this->emailService->sendUserKytNotes(
            'test@example.org',
            'test subject'
        );

        $this->assertFalse($result);
    }

    public function testSendUserKytProjects(): void
    {
        $result = $this->emailService->sendUserKytProjects(
            'test@example.org',
            'test subject'
        );

        $this->assertFalse($result);
    }

    public function testSendUserKytReminders(): void
    {
        $result = $this->emailService->sendUserKytReminders(
            'test@example.org',
            'test subject'
        );

        $this->assertFalse($result);
    }

    public function testSendUserKytRewards(): void
    {
        $result = $this->emailService->sendUserKytRewards(
            'test@example.org',
            'test subject'
        );

        $this->assertFalse($result);
    }

    public function testSendUserKytRoutines(): void
    {
        $result = $this->emailService->sendUserKytRoutines(
            'test@example.org',
            'test subject'
        );

        $this->assertFalse($result);
    }
}
