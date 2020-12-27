<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Reminder;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\ReminderManager;
use App\Manager\ReminderMessageManager;
use App\Manager\SentReminderManager;
use App\Repository\ReminderRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
        unset($this->reminderManager);
        unset($this->reminderMessageManager);
        unset($this->reminderRepository);
        unset($this->sentReminderManager);
        unset($this->userFaker);
        unset($this->validator);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $reminderManager = new ReminderManager(
            $this->entityManager,
            $this->reminderMessageManager,
            $this->sentReminderManager,
            $this->validator
        );

        $this->assertInstanceOf(ReminderManager::class, $reminderManager);
    }

    public function testBulkSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $minutesBefore = 5;
        $reminder = $user->getReminders()->first();
        $reminder->setMinutesBefore($minutesBefore);
        $reminderId = $reminder->getId();
        $reminders = [];
        $reminders[] = $reminder;

        $reminderManager = $this->reminderManager->bulkSave($reminders, (string) $user, 1);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminder2 = $this->reminderRepository->findOneById($reminderId);
        $this->assertInstanceOf(Reminder::class, $reminder2);
        $this->assertEquals($minutesBefore, $reminder2->getMinutesBefore());
    }

    public function testDelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();
        $reminderId = $reminder->getId();

        $reminderManager = $this->reminderManager->delete($reminder);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminder2 = $this->reminderRepository->findOneById($reminderId);
        $this->assertNull($reminder2);
    }

    public function testSave()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();

        $reminderManager = $this->reminderManager->save($reminder, (string) $user, true);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminderManager = $this->reminderManager->save($reminder);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);
    }

    public function testSaveException()
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();
        $reminder->setMinutesBefore(-1);

        $reminderManager = $this->reminderManager->save($reminder, (string) $user, true);
    }

    public function testSoftDelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();
        $reminderId = $reminder->getId();

        $reminderManager = $this->reminderManager->softDelete($reminder, (string) $user);
        $this->assertInstanceOf(ReminderManager::class, $reminderManager);

        $reminder2 = $this->reminderRepository->findOneById($reminderId);
        $this->assertInstanceOf(Reminder::class, $reminder2);
        $this->assertTrue(null !== $reminder2->getDeletedAt());
    }

    public function testUndelete()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();
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

    public function testValidate()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminder = $user->getReminders()->first();

        $errors = $this->reminderManager->validate($reminder);
        $this->assertCount(0, $errors);

        $reminder->setMinutesBefore(-1);
        $errors = $this->reminderManager->validate($reminder);
        $this->assertCount(2, $errors);
    }
}