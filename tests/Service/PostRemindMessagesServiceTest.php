<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Reminder;
use App\Factory\{ReminderMessageFactory, SentReminderFactory};
use App\Faker\{GoalFaker, QuoteFaker, UserFaker};
use App\Manager\{GoalManager, ReminderManager, ReminderMessageManager, SentReminderManager};
use App\Repository\{QuoteRepository, ReminderRepository};
use App\Service\Sms\SmsService;
use App\Service\{AccountOperationService, EmailService, PostRemindMessagesService, ReportService};
use App\Tests\AbstractDoctrineTestCase;
use AsyncAws\Core\Exception\Http\NetworkException;
use DateTimeImmutable;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\Routing\RouterInterface;

/**
 * @internal
 */
final class PostRemindMessagesServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountOperationService $accountOperationService;
    /**
     * @inject
     */
    private ?EmailService $emailService;
    /**
     * @inject
     */
    private ?GoalFaker $goalFaker;
    /**
     * @inject
     */
    private ?GoalManager $goalManager;
    /**
     * @inject
     */
    private ?PostRemindMessagesService $postRemindMessagesService;
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;
    /**
     * @inject
     */
    private ?QuoteRepository $quoteRepository;
    /**
     * @inject
     */
    private ?ReminderManager $reminderManager;
    /**
     * @inject
     */
    private ?ReminderMessageFactory $reminderMessageFactory;
    /**
     * @inject
     */
    private ?ReminderMessageManager $reminderMessageManager;
    /**
     * @inject
     */
    private ?ReminderRepository $reminderRepository;
    /**
     * @inject
     */
    private ?ReportService $reportService;
    /**
     * @inject
     */
    private ?RouterInterface $router;
    /**
     * @inject
     */
    private ?SentReminderFactory $sentReminderFactory;
    /**
     * @inject
     */
    private ?SentReminderManager $sentReminderManager;
    /**
     * @inject
     */
    private ?SmsService $smsService;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->accountOperationService = null;
        $this->emailService = null;
        $this->goalFaker = null;
        $this->goalManager = null;
        $this->postRemindMessagesService = null;
        $this->quoteFaker = null;
        $this->quoteRepository = null;
        $this->reminderManager = null;
        $this->reminderMessageFactory = null;
        $this->reminderMessageManager = null;
        $this->reminderRepository = null;
        $this->reportService = null;
        $this->router = null;
        $this->sentReminderFactory = null;
        $this->sentReminderManager = null;
        $this->smsService = null
        ;

        parent::tearDown();
    }

    public function createReminder(): Reminder
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getReminders()->first();
    }

    public function testConstruct(): void
    {
        $postRemindMessagesService = new PostRemindMessagesService(
            $this->accountOperationService,
            $this->emailService,
            $this->quoteRepository,
            $this->reminderManager,
            $this->reminderMessageFactory,
            $this->reminderMessageManager,
            $this->reminderRepository,
            $this->reportService,
            $this->router,
            $this->sentReminderFactory,
            $this->sentReminderManager,
            $this->smsService
        );

        $this->assertInstanceOf(PostRemindMessagesService::class, $postRemindMessagesService);
    }

    public function testFindNextReminder(): void
    {
        $this->purge();
        $report = $this->reportService->createPostRemindMessages();
        $reminder = $this->createReminder();

        $reminder2 = $this->postRemindMessagesService->findNextReminder($report);
        $this->assertNull($reminder2);

        $nextDate = new DateTimeImmutable('2021-01-01');
        $reminder->setNextDate($nextDate);
        $reminder->setIsEnabled(true);
        $reminder->getRoutine()->setIsEnabled(true);
        $this->entityManager->persist($reminder);
        $this->entityManager->persist($reminder->getRoutine());
        $this->entityManager->flush();

        $reminder3 = $this->postRemindMessagesService->findNextReminder($report);
        $this->assertInstanceOf(Reminder::class, $reminder3);
    }

    public function testFindOldLocked(): void
    {
        $this->purge();
        $reminder = $this->createReminder();

        $lockedAt = new DateTimeImmutable('2021-01-01');
        $reminder->setLockedAt($lockedAt);
        $reminder->setIsEnabled(true);
        $reminder->getRoutine()->setIsEnabled(true);
        $this->entityManager->persist($reminder);
        $this->entityManager->persist($reminder->getRoutine());
        $this->entityManager->flush();

        $this->assertInstanceOf(PostRemindMessagesService::class, $this->postRemindMessagesService->findOldLocked());
    }

    public function testNurture(): void
    {
        $this->purge();
        $reminder = $this->createReminder();

        $this->assertInstanceOf(PostRemindMessagesService::class, $this->postRemindMessagesService->nurture());
    }

    public function testPrepareReminderMessages(): void
    {
        $this->expectException(NetworkException::class);

        $this->purge();
        $report = $this->reportService->createPostRemindMessages();
        $this->quoteFaker->createQuotePersisted('test', 'test', true);
        $reminder = $this->createReminder();
        $routine = $reminder->getRoutine();
        $user = $reminder->getUser();
        $user
            ->setIsVerified(true)
            ->getAccount()
            ->setAvailableNotifications(10)
            ->setAvailableSmsNotifications(10)
        ;
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phone = $phoneNumberUtil->parse('+48881573056');

        $reminder->setSendEmail(true);
        $reminder->setSendSms(true);

        $reminder = $this->postRemindMessagesService->prepareReminderMessages($reminder, $report);
        $this->assertInstanceOf(Reminder::class, $reminder);

        $goal = $this->goalFaker->createGoal(null, false);
        $goal->setRoutine($routine);
        $goal->setUser($user);
        $this->goalManager->save($goal, (string) $user, true);
        $routine->addGoal($goal);

        $reminder = $this->postRemindMessagesService->prepareReminderMessages($reminder, $report);
        $this->assertInstanceOf(Reminder::class, $reminder);

        $goal = $this->goalFaker->createGoal(null, false);
        $goal->setRoutine($routine);
        $goal->setUser($user);
        $this->goalManager->save($goal, (string) $user, true);
        $routine->addGoal($goal);

        $reminder = $this->postRemindMessagesService->prepareReminderMessages($reminder, $report);
        $this->assertInstanceOf(Reminder::class, $reminder);

        $user
            ->getProfile()
            ->setPhone($phone)
            ->setIsVerified(true)
        ;

        $reminder = $this->postRemindMessagesService->prepareReminderMessages($reminder, $report);
        $this->assertInstanceOf(Reminder::class, $reminder);
    }
}
