<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\SentReminder;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\SentReminderManager;
use App\Repository\SentReminderRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SentReminderManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?SentReminderManager $sentReminderManager;
    /**
     * @inject
     */
    private ?SentReminderRepository $sentReminderRepository;
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
        unset(
            $this->sentReminderManager,
            $this->sentReminderRepository,
            $this->userFaker,
            $this->validator
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $sentReminderManager = new SentReminderManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $sentReminder = $user->getRoutines()->first()->getSentReminders()->first();
        $sentReminderId = $sentReminder->getId();
        $sentReminders = [];
        $sentReminders[] = $sentReminder;

        $sentReminderManager = $this->sentReminderManager->bulkSave($sentReminders, 1);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);

        $sentReminder2 = $this->sentReminderRepository->findOneById($sentReminderId);
        $this->assertInstanceOf(SentReminder::class, $sentReminder2);
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $sentReminder = $user->getRoutines()->first()->getSentReminders()->first();
        $sentReminderId = $sentReminder->getId();

        $sentReminderManager = $this->sentReminderManager->delete($sentReminder);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);

        $sentReminder2 = $this->sentReminderRepository->findOneById($sentReminderId);
        $this->assertNull($sentReminder2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $sentReminder = $user->getRoutines()->first()->getSentReminders()->first();

        $sentReminderManager = $this->sentReminderManager->save($sentReminder, true);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);

        $sentReminderManager = $this->sentReminderManager->save($sentReminder);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $sentReminder = $user->getRoutines()->first()->getSentReminders()->first();
        $sentReminder->getRoutine()->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $sentReminderManager = $this->sentReminderManager->save($sentReminder, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $sentReminder = $user->getRoutines()->first()->getSentReminders()->first();
        $sentReminderId = $sentReminder->getId();

        $sentReminderManager = $this->sentReminderManager->softDelete($sentReminder);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);

        $sentReminder2 = $this->sentReminderRepository->findOneById($sentReminderId);
        $this->assertInstanceOf(SentReminder::class, $sentReminder2);
        $this->assertTrue(null !== $sentReminder2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $sentReminder = $user->getRoutines()->first()->getSentReminders()->first();
        $sentReminderId = $sentReminder->getId();

        $sentReminderManager = $this->sentReminderManager->softDelete($sentReminder);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);

        $sentReminder2 = $this->sentReminderRepository->findOneById($sentReminderId);
        $this->assertInstanceOf(SentReminder::class, $sentReminder2);
        $this->assertTrue(null !== $sentReminder2->getDeletedAt());

        $sentReminderManager = $this->sentReminderManager->undelete($sentReminder);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);

        $sentReminder3 = $this->sentReminderRepository->findOneById($sentReminderId);
        $this->assertInstanceOf(SentReminder::class, $sentReminder3);
        $this->assertTrue(null === $sentReminder3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $sentReminder = $user->getRoutines()->first()->getSentReminders()->first();

        $errors = $this->sentReminderManager->validate($sentReminder);
        $this->assertCount(0, $errors);

        $sentReminder->getRoutine()->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->sentReminderManager->validate($sentReminder);
        $this->assertCount(1, $errors);
    }
}
