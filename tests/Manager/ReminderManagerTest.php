<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Reminder;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\{ReminderManager, ReminderMessageManager, SentReminderManager};
use App\Repository\ReminderRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 */
final class ReminderManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ReminderManager $reminderManager;
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
    private ?SentReminderManager $sentReminderManager;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        $this->reminderManager = null;
        $this->reminderMessageManager = null;
        $this->reminderRepository = null;
        $this->sentReminderManager = null;
        $this->userFaker = null;
        $this->validator = null
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
        $reminderManager = new ReminderManager(
            $this->entityManager,
            $this->reminderMessageManager,
            $this->sentReminderManager,
            $this->validator
        );

        $this->assertInstanceOf(ReminderManager::class, $reminderManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $reminder = $this->createReminder();
        $user = $reminder->getUser();
        $minutesBefore = 5;
        $reminder->setMinutesBefore($minutesBefore);
        $reminderId = $reminder->getId();
        $reminders = [];
        $reminders[] = $reminder;

        $reminderManager = $this->reminderManager->bulkSave($reminders, (string) $user, 1);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminder2 = $this->reminderRepository->findOneById($reminderId);
        $this->assertInstanceOf(Reminder::class, $reminder2);
        $this->assertSame($minutesBefore, $reminder2->getMinutesBefore());
    }

    public function testDelete(): void
    {
        $this->purge();
        $reminder = $this->createReminder();
        $reminderId = $reminder->getId();

        $reminderManager = $this->reminderManager->delete($reminder);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminder2 = $this->reminderRepository->findOneById($reminderId);
        $this->assertNull($reminder2);
    }

    public function testFindNextDate(): void
    {
        $this->purge();
        $reminder = $this->createReminder();
        $user = $reminder->getUser();
        $user->getProfile()->setTimeZone('wrong timezone');

        $nextDate = $reminderManager = $this->reminderManager->findNextDate($reminder);

        $this->assertInstanceOf(DateTimeImmutable::class, $nextDate);
    }

    public function testSave(): void
    {
        $this->purge();
        $reminder = $this->createReminder();
        $user = $reminder->getUser();

        $reminderManager = $this->reminderManager->save($reminder, (string) $user, true);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminderManager = $this->reminderManager->save($reminder);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $reminder = $this->createReminder();
        $user = $reminder->getUser();
        $reminder->setMinutesBefore(-1);

        $reminderManager = $this->reminderManager->save($reminder, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $reminder = $this->createReminder();
        $user = $reminder->getUser();
        $reminderId = $reminder->getId();

        $reminderManager = $this->reminderManager->softDelete($reminder, (string) $user);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminder2 = $this->reminderRepository->findOneById($reminderId);
        $this->assertInstanceOf(Reminder::class, $reminder2);
        $this->assertTrue(null !== $reminder2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $reminder = $this->createReminder();
        $user = $reminder->getUser();
        $sentReminder = $user->getRoutines()->first()->getSentReminders()->first();
        $reminder->addSentReminder($sentReminder);
        $reminderId = $reminder->getId();

        $reminderManager = $this->reminderManager->softDelete($reminder, (string) $user);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminder2 = $this->reminderRepository->findOneById($reminderId);
        $this->assertInstanceOf(Reminder::class, $reminder2);
        $this->assertTrue(null !== $reminder2->getDeletedAt());

        $reminderManager = $this->reminderManager->undelete($reminder);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminder3 = $this->reminderRepository->findOneById($reminderId);
        $this->assertInstanceOf(Reminder::class, $reminder3);
        $this->assertTrue(null === $reminder3->getDeletedAt());
    }

    public function testLock(): void
    {
        $this->purge();
        $reminder = $this->createReminder();

        $reminderManager = $this->reminderManager->lock($reminder);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);
        $this->assertTrue(null !== $reminder->getLockedAt());
    }

    public function testUnlock(): void
    {
        $this->purge();
        $reminder = $this->createReminder();

        $reminderManager = $this->reminderManager->lock($reminder);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);
        $this->assertTrue(null !== $reminder->getLockedAt());

        $reminderManager = $this->reminderManager->unlock($reminder);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);
        $this->assertTrue(null === $reminder->getLockedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $reminder = $this->createReminder();

        $errors = $this->reminderManager->validate($reminder);
        $this->assertCount(0, $errors);

        $reminder->setMinutesBefore(-1);
        $errors = $this->reminderManager->validate($reminder);
        $this->assertCount(2, $errors);
    }
}
