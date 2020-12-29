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
        unset($this->accountManager);
        unset($this->accountRepository);
        unset($this->userFaker);
        unset($this->validator);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $accountManager = new AccountManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(AccountManager::class, $accountManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $availableEmailNotifications = 987;
        $account = $user->getAccount();
        $account->setAvailableEmailNotifications($availableEmailNotifications);
        $accountId = $account->getId();
        $accounts = [];
        $accounts[] = $account;

        $accountManager = $this->accountManager->bulkSave($accounts, (string) $user, 1);
        $this->assertInstanceOf(AccountManager::class, $accountManager);

        $account2 = $this->accountRepository->findOneById($accountId);
        $this->assertInstanceOf(Account::class, $account2);
        $this->assertEquals($availableEmailNotifications, $account2->getAvailableEmailNotifications());
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $account = $user->getAccount();
        $accountId = $account->getId();

        $accountManager = $this->accountManager->delete($account);
        $this->assertInstanceOf(AccountManager::class, $accountManager);

        $account2 = $this->accountRepository->findOneById($accountId);
        $this->assertNull($account2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $account = $user->getAccount();

        $accountManager = $this->accountManager->save($account, (string) $user, true);
        $this->assertInstanceOf(AccountManager::class, $accountManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $account = $user->getAccount();
        $account->setAvailableEmailNotifications(-1);

        $accountManager = $this->accountManager->save($account, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $account = $user->getAccount();
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
        $user = $this->userFaker->createRichUserPersisted();
        $account = $user->getAccount();
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
        $user = $this->userFaker->createRichUserPersisted();
        $account = $user->getAccount();

        $errors = $this->accountManager->validate($account);
        $this->assertCount(0, $errors);

        $account->setAvailableEmailNotifications(-1);
        $errors = $this->accountManager->validate($account);
        $this->assertCount(1, $errors);
    }
}
