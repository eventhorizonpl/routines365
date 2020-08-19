<?php

namespace App\Service;

use App\Entity\Reminder;
use App\Entity\ReminderMessage;
use App\Factory\ReminderMessageFactory;
use App\Manager\ReminderManager;
use App\Manager\ReminderMessageManager;
use App\Repository\QuoteRepository;
use App\Repository\ReminderRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PostRemindMessagesService
{
    private AccountOperationService $accountOperationService;
    private EntityManagerInterface $entityManager;
    private QuoteRepository $quoteRepository;
    private ReminderManager $reminderManager;
    private ReminderMessageFactory $reminderMessageFactory;
    private ReminderMessageManager $reminderMessageManager;
    private ReminderRepository $reminderRepository;
    private RouterInterface $router;

    public function __construct(
        AccountOperationService $accountOperationService,
        EntityManagerInterface $entityManager,
        QuoteRepository $quoteRepository,
        ReminderManager $reminderManager,
        ReminderMessageFactory $reminderMessageFactory,
        ReminderMessageManager $reminderMessageManager,
        ReminderRepository $reminderRepository,
        RouterInterface $router
    ) {
        $this->accountOperationService = $accountOperationService;
        $this->entityManager = $entityManager;
        $this->quoteRepository = $quoteRepository;
        $this->reminderManager = $reminderManager;
        $this->reminderMessageFactory = $reminderMessageFactory;
        $this->reminderMessageManager = $reminderMessageManager;
        $this->reminderRepository = $reminderRepository;
        $this->router = $router;
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

    public function nurture(): self
    {
        while (true) {
            $this->findNextReminder();
        }
    }

    public function prepareReminderMessages(Reminder $reminder): Reminder
    {
        $message = 'Your routine '.$reminder->getRoutine()->getName();
        $message .= ' starts at '.$reminder->getNextDate()->format('H:i:s').'.';
        if ($reminder->getRoutine()->getGoals()->count() > 0) {
            $message .= ' You have '.$reminder->getRoutine()->getGoals()->count().' goals.';
        }
        $emailMessage = $message;
        $smsMessage = $message;
        if (true === $reminder->getSendMotivationalMessage()) {
            $message .= ' ';
            if (true === $reminder->getSendEmail()) {
                $messageLength = mb_strlen($message);
                $quote = $this->quoteRepository->findOneByStringLength();
                if (null !== $quote) {
                    $emailMessage = $message.(string) $quote;
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

        $account = $reminder->getUser()->getAccount();
        if ((true === $reminder->getSendEmail()) && ($account->getAvailableEmailNotifications() > 0)) {
            $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
                $emailMessage,
                ReminderMessage::TYPE_EMAIL
            );
            $reminderMessage->setReminder($reminder);
            $this->reminderMessageManager->save($reminderMessage);
            $accountOperation = $this->accountOperationService->withdraw(
                $account,
                'Email notification',
                1,
                0,
                $reminderMessage
            );
        }
        if ((true === $reminder->getSendSms()) && ($account->getAvailableSmsNotifications() > 0)) {
            $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
                $smsMessage,
                ReminderMessage::TYPE_SMS
            );
            $reminderMessage->setReminder($reminder);
            $this->reminderMessageManager->save($reminderMessage);
            $accountOperation = $this->accountOperationService->withdraw(
                $account,
                'SMS notification',
                0,
                1,
                $reminderMessage
            );
        }
        $this->reminderManager->save($reminder);

        return $reminder;
    }
}
