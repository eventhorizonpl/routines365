<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\AccountOperation;
use App\Enum\AccountOperationTypeEnum;
use App\Exception\AccountException;
use App\Factory\AccountOperationFactory;
use App\Faker\UserFaker;
use App\Manager\AccountOperationManager;
use App\Service\AccountOperationService;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
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
        $this->accountOperationFactory = null;
        $this->accountOperationManager = null;
        $this->accountOperationService = null;
        $this->userFaker = null
        ;

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
        $userReferrer = $this->userFaker->createRichUserPersisted('test@example.org', 'test');
        $user = $this->userFaker->createRichUserPersisted();
        $user->setReferrer($userReferrer);
        $user->getAccount();

        $description = 'test deposit';
        $notifications = 11;
        $smsNotifications = 12;

        $accountOperation = $this->accountOperationService->deposit(
            $user->getAccount(),
            $description,
            $notifications,
            $smsNotifications
        );
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
        $this->assertSame($description, $accountOperation->getDescription());
        $this->assertSame($notifications, $accountOperation->getNotifications());
        $this->assertSame($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertSame(AccountOperationTypeEnum::DEPOSIT, $accountOperation->getType());
    }

    public function testDepositException(): void
    {
        $this->expectException(AccountException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user->getAccount();

        $accountOperation = $this->accountOperationService->deposit(
            $user->getAccount(),
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

        $description = 'test withdraw';
        $notifications = 11;
        $smsNotifications = 12;

        $accountOperation = $this->accountOperationService->deposit(
            $user->getAccount(),
            'test deposit',
            $notifications,
            $smsNotifications,
        );

        $accountOperation = $this->accountOperationService->withdraw(
            $user->getAccount(),
            $description,
            $notifications,
            $smsNotifications,
            $reminderMessage
        );
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
        $this->assertSame($description, $accountOperation->getDescription());
        $this->assertSame($notifications, $accountOperation->getNotifications());
        $this->assertSame($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertSame(AccountOperationTypeEnum::WITHDRAW, $accountOperation->getType());
    }

    public function testWithdrawException(): void
    {
        $this->expectException(AccountException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $user->getAccount();

        $accountOperation = $this->accountOperationService->withdraw(
            $user->getAccount(),
            'test withdraw',
            100000,
            100000,
        );
    }
}
