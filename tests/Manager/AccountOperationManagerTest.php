<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\AccountOperation;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\AccountManager;
use App\Manager\AccountOperationManager;
use App\Repository\AccountOperationRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AccountOperationManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountManager $accountManager;
    /**
     * @inject
     */
    private ?AccountOperationManager $accountOperationManager;
    /**
     * @inject
     */
    private ?AccountOperationRepository $accountOperationRepository;
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
            $this->accountManager,
            $this->accountOperationManager,
            $this->accountOperationRepository,
            $this->userFaker,
            $this->validator
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $accountOperationManager = new AccountOperationManager($this->accountManager, $this->entityManager, $this->validator);

        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $smsNotifications = 987;
        $accountOperation = $user->getAccount()->getAccountOperations()->first();
        $accountOperation->setSmsNotifications($smsNotifications);
        $accountOperationId = $accountOperation->getId();
        $accountOperations = [];
        $accountOperations[] = $accountOperation;

        $accountOperationManager = $this->accountOperationManager->bulkSave($accountOperations, (string) $user, 1);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation2 = $this->accountOperationRepository->findOneById($accountOperationId);
        $this->assertInstanceOf(AccountOperation::class, $accountOperation2);
        $this->assertEquals($smsNotifications, $accountOperation2->getSmsNotifications());
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $accountOperation = $user->getAccount()->getAccountOperations()->first();
        $accountOperationId = $accountOperation->getId();

        $accountOperationManager = $this->accountOperationManager->delete($accountOperation);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation2 = $this->accountOperationRepository->findOneById($accountOperationId);
        $this->assertNull($accountOperation2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $accountOperation = $user->getAccount()->getAccountOperations()->first();

        $accountOperation->setType(AccountOperation::TYPE_DEPOSIT);
        $accountOperationManager = $this->accountOperationManager->save($accountOperation, (string) $user, true);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation->setType(AccountOperation::TYPE_WITHDRAW);
        $accountOperationManager = $this->accountOperationManager->save($accountOperation, (string) $user, true);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation->setType(AccountOperation::TYPE_WITHDRAW);
        $accountOperationManager = $this->accountOperationManager->save($accountOperation);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $accountOperation = $user->getAccount()->getAccountOperations()->first();
        $accountOperation->setSmsNotifications(2048);

        $accountOperationManager = $this->accountOperationManager->save($accountOperation, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $accountOperation = $user->getAccount()->getAccountOperations()->first();
        $accountOperationId = $accountOperation->getId();

        $accountOperationManager = $this->accountOperationManager->softDelete($accountOperation, (string) $user);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation2 = $this->accountOperationRepository->findOneById($accountOperationId);
        $this->assertInstanceOf(AccountOperation::class, $accountOperation2);
        $this->assertTrue(null !== $accountOperation2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $accountOperation = $user->getAccount()->getAccountOperations()->first();
        $accountOperationId = $accountOperation->getId();

        $accountOperationManager = $this->accountOperationManager->softDelete($accountOperation, (string) $user);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation2 = $this->accountOperationRepository->findOneById($accountOperationId);
        $this->assertInstanceOf(AccountOperation::class, $accountOperation2);
        $this->assertTrue(null !== $accountOperation2->getDeletedAt());

        $accountOperationManager = $this->accountOperationManager->undelete($accountOperation);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation3 = $this->accountOperationRepository->findOneById($accountOperationId);
        $this->assertInstanceOf(AccountOperation::class, $accountOperation3);
        $this->assertTrue(null === $accountOperation3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $accountOperation = $user->getAccount()->getAccountOperations()->first();

        $errors = $this->accountOperationManager->validate($accountOperation);
        $this->assertCount(0, $errors);

        $accountOperation->setSmsNotifications(2048);
        $errors = $this->accountOperationManager->validate($accountOperation);
        $this->assertCount(1, $errors);
    }
}
