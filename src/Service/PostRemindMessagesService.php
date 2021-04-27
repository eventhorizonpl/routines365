<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{Reminder, ReminderMessage, Report};
use App\Factory\{ReminderMessageFactory, SentReminderFactory};
use App\Manager\{ReminderManager, ReminderMessageManager, SentReminderManager};
use App\Repository\{QuoteRepository, ReminderRepository};
use App\Service\Sms\SmsService;
use DateTimeImmutable;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class PostRemindMessagesService
{
    public function __construct(
        private AccountOperationService $accountOperationService,
        private EmailService $emailService,
        private QuoteRepository $quoteRepository,
        private ReminderManager $reminderManager,
        private ReminderMessageFactory $reminderMessageFactory,
        private ReminderMessageManager $reminderMessageManager,
        private ReminderRepository $reminderRepository,
        private ReportService $reportService,
        private RouterInterface $router,
        private SentReminderFactory $sentReminderFactory,
        private SentReminderManager $sentReminderManager,
        private SmsService $smsService
    ) {
    }

    public function findNextReminder(Report $report): ?Reminder
    {
        $nextDate = new DateTimeImmutable();
        $reminder = $this->reminderRepository->findOneByNextDate($nextDate);

        if (null !== $reminder) {
            $this->reminderManager->lock($reminder);
            $reminder = $this->prepareReminderMessages($reminder, $report);
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
        $report = $this->reportService->createPostRemindMessages();
        for ($i = 0; $i < 50; ++$i) {
            $this->findNextReminder($report);
        }

        $report = $this->reportService->finish($report);

        $this->findOldLocked();

        return $this;
    }

    public function prepareReminderMessages(
        Reminder $reminder,
        Report $report
    ): Reminder {
        $data = [
            Report::DATA_KEY_REMINDER => $reminder->getUuid(),
        ];

        $message = sprintf(
            'Your routine %s',
            $reminder->getRoutine()->getName()
        );
        $message .= sprintf(
            ' starts at %s.',
            $reminder->getRoutineStartDateLocalTime()->format('H:i:s')
        );
        if ($reminder->getRoutine()->getGoalsNotCompletedCount() > 0) {
            $message .= sprintf(
                ' You have %d ',
                $reminder->getRoutine()->getGoalsNotCompletedCount()
            );
            if ($reminder->getRoutine()->getGoalsNotCompletedCount() > 1) {
                $message .= 'goals.';
            } else {
                $message .= 'goal.';
            }
        }
        $browserMessage = $message;
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
                    $emailMessage = sprintf(
                        '%s %s',
                        $message,
                        (string) $quote
                    );
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
        $emailMessage .= sprintf(
            ' Click this link when you finish %s',
            $link
        );
        $emailLink = $link;

        $account = $reminder->getUser()->getAccount();
        $createSentReminder = false;
        if (((true === $reminder->getSendEmail()) && (true === $account->canWithdrawNotifications(1)))
            || ((true === $reminder->getSendSms()) && (true === $account->canWithdrawSmsNotifications(1)))
            || (true === $reminder->getSendToBrowser())
        ) {
            $createSentReminder = true;
        }

        $data[Report::DATA_KEY_CREATE_SENT_REMINDER] = $createSentReminder;

        if (true === $createSentReminder) {
            $sentReminder = $this->sentReminderFactory->createSentReminder();
            $sentReminder->setReminder($reminder);
            $sentReminder->setRoutine($reminder->getRoutine());
            $this->sentReminderManager->save($sentReminder);
            $data[Report::DATA_KEY_SENT_REMINDER] = $sentReminder->getUuid();
        } else {
            $sentReminder = null;
        }

        if (null !== $sentReminder) {
            if ((true === $reminder->getUser()->getIsVerified())
                && (true === $reminder->getSendEmail())
                && (true === $account->canWithdrawNotifications(1))
            ) {
                $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
                    $emailMessage,
                    ReminderMessage::TYPE_EMAIL
                );
                $reminderMessage
                    ->setReminder($reminder)
                    ->setSentReminder($sentReminder)
                ;
                $this->reminderMessageManager->save($reminderMessage);

                $response = (string) $this->emailService->sendReminderMessage(
                    $reminder->getUser()->getEmail(),
                    'R365: Routine reminder',
                    [
                        'available_email_notifications' => $reminder->getUser()->getAccount()->getAvailableNotifications(),
                        'available_sms_notifications' => $reminder->getUser()->getAccount()->getAvailableSmsNotifications(),
                        'email_link' => $emailLink,
                        'email_original_message' => $emailOriginalMessage,
                        'email_quote' => $emailQuote,
                        'recipient_first_name' => $reminder->getUser()->getProfile()->getFirstName(),
                    ]
                );

                $reminderMessage
                    ->setPostDate(new DateTimeImmutable())
                    ->setThirdPartySystemType(ReminderMessage::THIRD_PARTY_SYSTEM_TYPE_AMAZON_SES)
                    ->setThirdPartySystemResponse($response)
                ;
                $this->reminderMessageManager->save($reminderMessage);

                $data[Report::DATA_KEY_REMINDER_MESSAGE] = $reminderMessage->getUuid();

                $accountOperation = $this->accountOperationService->withdraw(
                    $account,
                    'Email notification',
                    1,
                    0,
                    $reminderMessage
                );
            }
            if ((true === $reminder->getUser()->getProfile()->getIsVerified())
                && (true === $reminder->getSendSms())
                && (true === $account->canWithdrawSmsNotifications(1))
            ) {
                $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
                    $smsMessage,
                    ReminderMessage::TYPE_SMS
                );
                $reminderMessage
                    ->setReminder($reminder)
                    ->setSentReminder($sentReminder)
                ;
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
                    ->setThirdPartySystemResponse($response)
                ;
                $this->reminderMessageManager->save($reminderMessage);

                $data[Report::DATA_KEY_REMINDER_MESSAGE] = $reminderMessage->getUuid();

                $accountOperation = $this->accountOperationService->withdraw(
                    $account,
                    'SMS notification',
                    0,
                    1,
                    $reminderMessage
                );
            }
            if ((true === $reminder->getSendToBrowser())
                && (true === $account->canWithdrawNotifications(1))
            ) {
                $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
                    $browserMessage,
                    ReminderMessage::TYPE_BROWSER
                );
                $reminderMessage
                    ->setPostDate(new DateTimeImmutable())
                    ->setReminder($reminder)
                    ->setSentReminder($sentReminder)
                ;
                $this->reminderMessageManager->save($reminderMessage);

                $data[Report::DATA_KEY_REMINDER_MESSAGE] = $reminderMessage->getUuid();

                $accountOperation = $this->accountOperationService->withdraw(
                    $account,
                    'Browser notification',
                    1,
                    0,
                    $reminderMessage
                );
            }
        }

        $this->reminderManager->save($reminder);

        $this->reportService->addData($data, $report);

        return $reminder;
    }
}
