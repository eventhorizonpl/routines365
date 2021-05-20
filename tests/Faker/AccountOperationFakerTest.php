<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\AccountOperation;
use App\Enum\AccountOperationTypeEnum;
use App\Factory\AccountOperationFactory;
use App\Faker\AccountOperationFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
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
        $this->accountOperationFactory = null;
        $this->accountOperationFaker = null
        ;

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
        $type = AccountOperationTypeEnum::DEPOSIT;
        $accountOperation = $this->accountOperationFaker->createAccountOperation(
            $description,
            $notifications,
            $smsNotifications,
            $type
        );
        $this->assertSame($description, $accountOperation->getDescription());
        $this->assertSame($notifications, $accountOperation->getNotifications());
        $this->assertSame($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertSame($type, $accountOperation->getType());
    }
}
