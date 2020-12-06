<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Reminder;
use App\Entity\ReminderMessage;
use App\Factory\ReminderMessageFactory;
use App\Factory\SentReminderFactory;
use App\Manager\ReminderManager;
use App\Manager\ReminderMessageManager;
use App\Manager\SentReminderManager;
use App\Repository\QuoteRepository;
use App\Repository\ReminderRepository;
use App\Service\Sms\SmsService;
use DateTimeImmutable;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class PostRemindMessagesService
{
    private AccountOperationService $accountOperationService;
    private EmailService $emailService;
    private QuoteRepository $quoteRepository;
    private ReminderManager $reminderManager;
    private ReminderMessageFactory $reminderMessageFactory;
    private ReminderMessageManager $reminderMessageManager;
    private ReminderRepository $reminderRepository;
    private RouterInterface $router;
    private SentReminderFactory $sentReminderFactory;
    private SentReminderManager $sentReminderManager;
    private SmsService $smsService;

    public function __construct(
        AccountOperationService $accountOperationService,
        EmailService $emailService,
        QuoteRepository $quoteRepository,
        ReminderManager $reminderManager,
        ReminderMessageFactory $reminderMessageFactory,
        ReminderMessageManager $reminderMessageManager,
        ReminderRepository $reminderRepository,
        RouterInterface $router,
        SentReminderFactory $sentReminderFactory,
        SentReminderManager $sentReminderManager,
        SmsService $smsService
    ) {
        $this->accountOperationService = $accountOperationService;
        $this->emailService = $emailService;
        $this->quoteRepository = $quoteRepository;
        $this->reminderManager = $reminderManager;
        $this->reminderMessageFactory = $reminderMessageFactory;
        $this->reminderMessageManager = $reminderMessageManager;
        $this->reminderRepository = $reminderRepository;
        $this->router = $router;
        $this->sentReminderFactory = $sentReminderFactory;
        $this->sentReminderManager = $sentReminderManager;
        $this->smsService = $smsService;
    }

    public function findNextReminder(): ?Reminder
    {
        $nextDate = new DateTimeImmutable();
        $reminder = $this->reminderRepository->findOneByNextDate($nextDate);

        if (null !== $reminder) {
            $this->reminderManager->lock($reminder);
            $reminder = $this->prepareReminderMessages($reminder);
            $this->reminderManager->unlock($reminder);
        }

        return $reminder;
    }

    public function findOldLocked(): self
    {
        $lockedAt = new DateTimeImmutable('-10 minutes');
        $reminders = $this->reminderRepository->findByLockedAt($lockedAt);

        foreach ($reminders as $reminder) {
            $this->reminderManager->unlock($reminder);
        }

        return $this;
    }

    public function nurture(): self
    {
        for ($i = 0; $i < 50; ++$i) {
            $this->findNextReminder();
        }

        $this->findOldLocked();

        return $this;
    }

    public function prepareReminderMessages(Reminder $reminder): Reminder
    {
        $message = 'Your routine '.$reminder->getRoutine()->getName();
        $message .= ' starts at '.$reminder->getRoutineStartDate()->format('H:i:s').'.';
        if ($reminder->getRoutine()->getGoals()->count() > 0) {
            $message .= ' You have '.$reminder->getRoutine()->getGoals()->count().' goals.';
        }
        $emailMessage = $message;
        $emailOriginalMessage = $message;
        $emailQuote = null;
        $smsMessage = $message;
        if (true === $reminder->getSendMotivationalMessage()) {
            $message .= ' ';
            if (true === $reminder->getSendEmail()) {
                $messageLength = mb_strlen($message);
                $quote = $this->quoteRepository->findOneByStringLength();
                if (null !== $quote) {
                    $emailMessage = $message.' '.(string) $quote;
                    $emailQuote = (string) $quote;
                }
            }
            if (true === $reminder->getSendSms()) {
                $messageLength = mb_strlen($message);
                $stringLength = 140 - $messageLength;
                $quote = $this->quoteRepository->findOneByStringLength($stringLength);
                if (null !== $quote) {
                    $smsMessage = $message.(string) $quote;
                }
            }
        }

        $link = $this->router->generate('frontend_completed_routine_new', [
            'uuid' => $reminder->getRoutine()->getUuid(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
        $emailMessage .= ' Click this link when you finish '.$link;
        $emailLink = $link;

        $account = $reminder->getUser()->getAccount();
        $createSentReminder = false;
        if (((true === $reminder->getSendEmail()) && (true === $account->canWithdrawEmailNotifications(1))) ||
            ((true === $reminder->getSendSms()) && (true === $account->canWithdrawSmsNotifications(1)))) {
            $createSentReminder = true;
        }

        if (true === $createSentReminder) {
            $sentReminder = $this->sentReminderFactory->createSentReminder();
            $sentReminder->setReminder($reminder);
            $sentReminder->setRoutine($reminder->getRoutine());
            $this->sentReminderManager->save($sentReminder);
        } else {
            $sentReminder = null;
        }

        if (null !== $sentReminder) {
            if ((true === $reminder->getUser()->getIsVerified()) &&
                (true === $reminder->getSendEmail()) &&
                (true === $account->canWithdrawEmailNotifications(1))
            ) {
                $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
                    $emailMessage,
                    ReminderMessage::TYPE_EMAIL
                );
                $reminderMessage
                    ->setReminder($reminder)
                    ->setSentReminder($sentReminder);
                $this->reminderMessageManager->save($reminderMessage);

                $response = (string) $this->emailService->sendReminderMessage(
                    $reminder->getUser()->getEmail(),
                    'R365: Routine reminder',
                    [
                        'available_email_notifications' => $reminder->getUser()->getAccount()->getAvailableEmailNotifications(),
                        'available_sms_notifications' => $reminder->getUser()->getAccount()->getAvailableSmsNotifications(),
                        'email_link' => $emailLink,
                        'email_original_message' => $emailOriginalMessage,
                        'email_quote' => $emailQuote,
                    ]
                );

                $reminderMessage
                    ->setPostDate(new DateTimeImmutable())
                    ->setThirdPartySystemType(ReminderMessage::THIRD_PARTY_SYSTEM_TYPE_AMAZON_SES)
                    ->setThirdPartySystemResponse($response);
                $this->reminderMessageManager->save($reminderMessage);

                $accountOperation = $this->accountOperationService->withdraw(
                    $account,
                    'Email notification',
                    1,
                    0,
                    $reminderMessage
                );
            }
            if ((true === $reminder->getUser()->getProfile()->getIsVerified()) &&
                (true === $reminder->getSendSms()) &&
                (true === $account->canWithdrawSmsNotifications(1))
            ) {
                $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
                    $smsMessage,
                    ReminderMessage::TYPE_SMS
                );
                $reminderMessage
                    ->setReminder($reminder)
                    ->setSentReminder($sentReminder);
                $this->reminderMessageManager->save($reminderMessage);

                $response = $this->smsService->sendReminderMessage(
                    $reminder->getUser()->getProfile()->getPhoneString(),
                    [
                        'sms_message' => $smsMessage,
                    ]
                );

                $reminderMessage
                    ->setPostDate(new DateTimeImmutable())
                    ->setThirdPartySystemType(ReminderMessage::THIRD_PARTY_SYSTEM_TYPE_AMAZON_SNS)
                    ->setThirdPartySystemResponse($response);
                $this->reminderMessageManager->save($reminderMessage);

                $accountOperation = $this->accountOperationService->withdraw(
                    $account,
                    'SMS notification',
                    0,
                    1,
                    $reminderMessage
                );
            }
        }

        $this->reminderManager->save($reminder);

        return $reminder;
    }
}
