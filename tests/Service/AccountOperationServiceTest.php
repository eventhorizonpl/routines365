<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\AccountOperation;
use App\Exception\AccountException;
use App\Factory\AccountOperationFactory;
use App\Faker\UserFaker;
use App\Manager\AccountOperationManager;
use App\Service\AccountOperationService;
use App\Tests\AbstractDoctrineTestCase;

final class AccountOperationServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountOperationFactory $accountOperationFactory;
    /**
     * @inject
     */
    private ?AccountOperationManager $accountOperationManager;
    /**
     * @inject
     */
    private ?AccountOperationService $accountOperationService;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset(
            $this->accountOperationFactory,
            $this->accountOperationManager,
            $this->accountOperationService,
            $this->userFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $accountOperationService = new AccountOperationService($this->accountOperationFactory, $this->accountOperationManager);

        $this->assertInstanceOf(AccountOperationService::class, $accountOperationService);
    }

    public function testDeposit(): void
    {
        $this->purge();
        $userReferrer = $this->userFaker->createRichUserPersisted();
        $user = $this->userFaker->createRichUserPersisted();
        $user->setReferrer($userReferrer);
        $user->getAccount();

        $browserNotifications = 10;
        $description = 'test deposit';
        $emailNotifications = 11;
        $smsNotifications = 12;

        $accountOperation = $this->accountOperationService->deposit(
            $user->getAccount(),
            $browserNotifications,
            $description,
            $emailNotifications,
            $smsNotifications
        );
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
        $this->assertEquals($browserNotifications, $accountOperation->getBrowserNotifications());
        $this->assertEquals($description, $accountOperation->getDescription());
        $this->assertEquals($emailNotifications, $accountOperation->getEmailNotifications());
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertEquals(AccountOperation::TYPE_DEPOSIT, $accountOperation->getType());
    }

    public function testDepositException(): void
    {
        $this->expectException(AccountException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user->getAccount();

        $accountOperation = $this->accountOperationService->deposit(
            $user->getAccount(),
            100000,
            'test deposit',
            100000,
            100000,
        );
    }

    public function testWithdraw(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reminderMessage = $user->getReminders()->first()->getReminderMessages()->first();
        $user->getAccount();

        $browserNotifications = 10;
        $description = 'test withdraw';
        $emailNotifications = 11;
        $smsNotifications = 12;

        $accountOperation = $this->accountOperationService->withdraw(
            $user->getAccount(),
            $browserNotifications,
            $description,
            $emailNotifications,
            $smsNotifications,
            $reminderMessage
        );
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
        $this->assertEquals($browserNotifications, $accountOperation->getBrowserNotifications());
        $this->assertEquals($description, $accountOperation->getDescription());
        $this->assertEquals($emailNotifications, $accountOperation->getEmailNotifications());
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertEquals(AccountOperation::TYPE_WITHDRAW, $accountOperation->getType());
    }

    public function testWithdrawException(): void
    {
        $this->expectException(AccountException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user->getAccount();

        $accountOperation = $this->accountOperationService->withdraw(
            $user->getAccount(),
            100000,
            'test withdraw',
            100000,
            100000,
        );
    }
}
