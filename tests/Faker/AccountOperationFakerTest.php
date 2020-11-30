<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\AccountOperation;
use App\Factory\AccountOperationFactory;
use App\Faker\AccountOperationFaker;
use App\Tests\AbstractDoctrineTestCase;

class AccountOperationFakerTest extends AbstractDoctrineTestCase
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
        unset($this->accountOperationFactory);
        unset($this->accountOperationFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $accountOperationFaker = new AccountOperationFaker($this->accountOperationFactory);

        $this->assertInstanceOf(AccountOperationFaker::class, $accountOperationFaker);
    }

    public function testCreateAccountOperation()
    {
        $this->purge();
        $accountOperation = $this->accountOperationFaker->createAccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
        $description = 'test description';
        $emailNotifications = 1;
        $smsNotifications = 2;
        $type = 'test type';
        $accountOperation = $this->accountOperationFaker->createAccountOperation(
            $description,
            $emailNotifications,
            $smsNotifications,
            $type
        );
        $this->assertEquals($description, $accountOperation->getDescription());
        $this->assertEquals($emailNotifications, $accountOperation->getEmailNotifications());
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertEquals($type, $accountOperation->getType());
    }
}
