<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\AccountOperation;
use App\Enum\AccountOperationTypeEnum;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\{AccountManager, AccountOperationManager};
use App\Repository\AccountOperationRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 */
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
        $this->accountManager = null;
        $this->accountOperationManager = null;
        $this->accountOperationRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function createAccountOperation(): AccountOperation
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getAccount()->getAccountOperations()->first();
    }

    public function testConstruct(): void
    {
        $accountOperationManager = new AccountOperationManager($this->accountManager, $this->entityManager, $this->validator);

        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $accountOperation = $this->createAccountOperation();
        $user = $accountOperation->getAccount()->getUsers()->first();
        $smsNotifications = 987;
        $accountOperation->setSmsNotifications($smsNotifications);
        $accountOperationId = $accountOperation->getId();
        $accountOperations = [];
        $accountOperations[] = $accountOperation;

        $accountOperationManager = $this->accountOperationManager->bulkSave($accountOperations, (string) $user, 1);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation2 = $this->accountOperationRepository->findOneById($accountOperationId);
        $this->assertInstanceOf(AccountOperation::class, $accountOperation2);
        $this->assertSame($smsNotifications, $accountOperation2->getSmsNotifications());
    }

    public function testDelete(): void
    {
        $this->purge();
        $accountOperation = $this->createAccountOperation();
        $accountOperationId = $accountOperation->getId();

        $accountOperationManager = $this->accountOperationManager->delete($accountOperation);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation2 = $this->accountOperationRepository->findOneById($accountOperationId);
        $this->assertNull($accountOperation2);
    }

    public function testSave(): void
    {
        $this->purge();
        $accountOperation = $this->createAccountOperation();
        $user = $accountOperation->getAccount()->getUsers()->first();

        $accountOperation->setType(AccountOperationTypeEnum::DEPOSIT);
        $accountOperationManager = $this->accountOperationManager->save($accountOperation, (string) $user, true);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation->setType(AccountOperationTypeEnum::WITHDRAW);
        $accountOperationManager = $this->accountOperationManager->save($accountOperation, (string) $user, true);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);

        $accountOperation->setType(AccountOperationTypeEnum::WITHDRAW);
        $accountOperationManager = $this->accountOperationManager->save($accountOperation);
        $this->assertInstanceOf(AccountOperationManager::class, $accountOperationManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $accountOperation = $this->createAccountOperation();
        $user = $accountOperation->getAccount()->getUsers()->first();
        $accountOperation->setSmsNotifications(2048);

        $accountOperationManager = $this->accountOperationManager->save($accountOperation, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $accountOperation = $this->createAccountOperation();
        $user = $accountOperation->getAccount()->getUsers()->first();
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
        $accountOperation = $this->createAccountOperation();
        $user = $accountOperation->getAccount()->getUsers()->first();
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
        $accountOperation = $this->createAccountOperation();

        $errors = $this->accountOperationManager->validate($accountOperation);
        $this->assertCount(0, $errors);

        $accountOperation->setSmsNotifications(2048);
        $errors = $this->accountOperationManager->validate($accountOperation);
        $this->assertCount(1, $errors);
    }
}
