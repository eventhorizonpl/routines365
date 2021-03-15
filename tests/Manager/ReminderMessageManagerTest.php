<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\ReminderMessage;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\ReminderMessageManager;
use App\Repository\ReminderMessageRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 * @coversNothing
 */
final class ReminderMessageManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ReminderMessageManager $reminderMessageManager;
    /**
     * @inject
     */
    private ?ReminderMessageRepository $reminderMessageRepository;
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
        $this->reminderMessageManager = null;
        $this->reminderMessageRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function createReminderMessage(): ReminderMessage
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getReminders()->first()->getReminderMessages()->first();
    }

    public function testConstruct(): void
    {
        $reminderMessageManager = new ReminderMessageManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(ReminderMessageManager::class, $reminderMessageManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $reminderMessage = $this->createReminderMessage();
        $reminderMessageId = $reminderMessage->getId();
        $reminderMessages = [];
        $reminderMessages[] = $reminderMessage;

        $reminderMessageManager = $this->reminderMessageManager->bulkSave($reminderMessages, 1);
        $this->assertInstanceOf(ReminderMessageManager::class, $reminderMessageManager);

        $reminderMessage2 = $this->reminderMessageRepository->findOneById($reminderMessageId);
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage2);
    }

    public function testDelete(): void
    {
        $this->purge();
        $reminderMessage = $this->createReminderMessage();
        $reminderMessageId = $reminderMessage->getId();

        $reminderMessageManager = $this->reminderMessageManager->delete($reminderMessage);
        $this->assertInstanceOf(ReminderMessageManager::class, $reminderMessageManager);

        $reminderMessage2 = $this->reminderMessageRepository->findOneById($reminderMessageId);
        $this->assertNull($reminderMessage2);
    }

    public function testSave(): void
    {
        $this->purge();
        $reminderMessage = $this->createReminderMessage();

        $reminderMessageManager = $this->reminderMessageManager->save($reminderMessage, true);
        $this->assertInstanceOf(ReminderMessageManager::class, $reminderMessageManager);

        $reminderMessageManager = $this->reminderMessageManager->save($reminderMessage);
        $this->assertInstanceOf(ReminderMessageManager::class, $reminderMessageManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $reminderMessage = $this->createReminderMessage();
        $reminderMessage->setThirdPartySystemResponse('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $reminderMessageManager = $this->reminderMessageManager->save($reminderMessage, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $reminderMessage = $this->createReminderMessage();
        $reminderMessageId = $reminderMessage->getId();

        $reminderMessageManager = $this->reminderMessageManager->softDelete($reminderMessage);
        $this->assertInstanceOf(ReminderMessageManager::class, $reminderMessageManager);

        $reminderMessage2 = $this->reminderMessageRepository->findOneById($reminderMessageId);
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage2);
        $this->assertTrue(null !== $reminderMessage2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $reminderMessage = $this->createReminderMessage();
        $reminderMessageId = $reminderMessage->getId();

        $reminderMessageManager = $this->reminderMessageManager->softDelete($reminderMessage);
        $this->assertInstanceOf(ReminderMessageManager::class, $reminderMessageManager);

        $reminderMessage2 = $this->reminderMessageRepository->findOneById($reminderMessageId);
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage2);
        $this->assertTrue(null !== $reminderMessage2->getDeletedAt());

        $reminderMessageManager = $this->reminderMessageManager->undelete($reminderMessage);
        $this->assertInstanceOf(ReminderMessageManager::class, $reminderMessageManager);

        $reminderMessage3 = $this->reminderMessageRepository->findOneById($reminderMessageId);
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage3);
        $this->assertTrue(null === $reminderMessage3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $reminderMessage = $this->createReminderMessage();

        $errors = $this->reminderMessageManager->validate($reminderMessage);
        $this->assertCount(0, $errors);

        $reminderMessage->setThirdPartySystemResponse('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->reminderMessageManager->validate($reminderMessage);
        $this->assertCount(1, $errors);
    }
}
