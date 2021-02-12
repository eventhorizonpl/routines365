<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\AccountOperation;
use App\Factory\AccountOperationFactory;
use App\Faker\AccountOperationFaker;
use App\Tests\AbstractDoctrineTestCase;

final class AccountOperationFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountOperationFactory $accountOperationFactory;
    /**
     * @inject
     */
    private ?AccountOperationFaker $accountOperationFaker;

    protected function tearDown(): void
    {
        unset(
            $this->accountOperationFactory,
            $this->accountOperationFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $accountOperationFaker = new AccountOperationFaker($this->accountOperationFactory);

        $this->assertInstanceOf(AccountOperationFaker::class, $accountOperationFaker);
    }

    public function testCreateAccountOperation(): void
    {
        $this->purge();
        $accountOperation = $this->accountOperationFaker->createAccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
        $description = 'test description';
        $notifications = 1;
        $smsNotifications = 2;
        $type = AccountOperation::TYPE_DEPOSIT;
        $accountOperation = $this->accountOperationFaker->createAccountOperation(
            $description,
            $notifications,
            $smsNotifications,
            $type
        );
        $this->assertEquals($description, $accountOperation->getDescription());
        $this->assertEquals($notifications, $accountOperation->getNotifications());
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertEquals($type, $accountOperation->getType());
    }
}
