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

/**
 * @internal
 */
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
        $this->sentReminderManager = null;
        $this->sentReminderRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function createSentReminder(): SentReminder
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getRoutines()->first()->getSentReminders()->first();
    }

    public function testConstruct(): void
    {
        $sentReminderManager = new SentReminderManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $sentReminder = $this->createSentReminder();
        $user = $sentReminder->getRoutine()->getUser();
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
        $sentReminder = $this->createSentReminder();
        $sentReminderId = $sentReminder->getId();

        $sentReminderManager = $this->sentReminderManager->delete($sentReminder);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);

        $sentReminder2 = $this->sentReminderRepository->findOneById($sentReminderId);
        $this->assertNull($sentReminder2);
    }

    public function testSave(): void
    {
        $this->purge();
        $sentReminder = $this->createSentReminder();

        $sentReminderManager = $this->sentReminderManager->save($sentReminder, true);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);

        $sentReminderManager = $this->sentReminderManager->save($sentReminder);
        $this->assertInstanceOf(SentReminderManager::class, $sentReminderManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $sentReminder = $this->createSentReminder();
        $sentReminder->getRoutine()->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $sentReminderManager = $this->sentReminderManager->save($sentReminder, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $sentReminder = $this->createSentReminder();
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
        $sentReminder = $this->createSentReminder();
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
        $sentReminder = $this->createSentReminder();

        $errors = $this->sentReminderManager->validate($sentReminder);
        $this->assertCount(0, $errors);

        $sentReminder->getRoutine()->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->sentReminderManager->validate($sentReminder);
        $this->assertCount(1, $errors);
    }
}
