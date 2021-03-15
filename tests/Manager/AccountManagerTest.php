<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Account;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\AccountManager;
use App\Repository\AccountRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 * @coversNothing
 */
final class AccountManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountManager $accountManager;
    /**
     * @inject
     */
    private ?AccountRepository $accountRepository;
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
        $this->accountRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function createAccount(): Account
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getAccount();
    }

    public function testConstruct(): void
    {
        $accountManager = new AccountManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(AccountManager::class, $accountManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $account = $this->createAccount();
        $user = $account->getUsers()->first();
        $availableNotifications = 987;
        $account->setAvailableNotifications($availableNotifications);
        $accountId = $account->getId();
        $accounts = [];
        $accounts[] = $account;

        $accountManager = $this->accountManager->bulkSave($accounts, (string) $user, 1);
        $this->assertInstanceOf(AccountManager::class, $accountManager);

        $account2 = $this->accountRepository->findOneById($accountId);
        $this->assertInstanceOf(Account::class, $account2);
        $this->assertSame($availableNotifications, $account2->getAvailableNotifications());
    }

    public function testDelete(): void
    {
        $this->purge();
        $account = $this->createAccount();
        $accountId = $account->getId();

        $accountManager = $this->accountManager->delete($account);
        $this->assertInstanceOf(AccountManager::class, $accountManager);

        $account2 = $this->accountRepository->findOneById($accountId);
        $this->assertNull($account2);
    }

    public function testSave(): void
    {
        $this->purge();
        $account = $this->createAccount();
        $user = $account->getUsers()->first();

        $accountManager = $this->accountManager->save($account, (string) $user, true);
        $this->assertInstanceOf(AccountManager::class, $accountManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $account = $this->createAccount();
        $user = $account->getUsers()->first();
        $account->setAvailableNotifications(-1);

        $accountManager = $this->accountManager->save($account, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $account = $this->createAccount();
        $user = $account->getUsers()->first();
        $accountId = $account->getId();

        $accountManager = $this->accountManager->softDelete($account, (string) $user);
        $this->assertInstanceOf(AccountManager::class, $accountManager);

        $account2 = $this->accountRepository->findOneById($accountId);
        $this->assertInstanceOf(Account::class, $account2);
        $this->assertTrue(null !== $account2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $account = $this->createAccount();
        $user = $account->getUsers()->first();
        $accountId = $account->getId();

        $accountManager = $this->accountManager->softDelete($account, (string) $user);
        $this->assertInstanceOf(AccountManager::class, $accountManager);

        $account2 = $this->accountRepository->findOneById($accountId);
        $this->assertInstanceOf(Account::class, $account2);
        $this->assertTrue(null !== $account2->getDeletedAt());

        $accountManager = $this->accountManager->undelete($account);
        $this->assertInstanceOf(AccountManager::class, $accountManager);

        $account3 = $this->accountRepository->findOneById($accountId);
        $this->assertInstanceOf(Account::class, $account3);
        $this->assertTrue(null === $account3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $account = $this->createAccount();

        $errors = $this->accountManager->validate($account);
        $this->assertCount(0, $errors);

        $account->setAvailableNotifications(-1);
        $errors = $this->accountManager->validate($account);
        $this->assertCount(1, $errors);
    }
}
