<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\AccountOperation;
use App\Factory\AccountOperationFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

class AccountOperationFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $accountOperationFactory = new AccountOperationFactory();

        $this->assertInstanceOf(AccountOperationFactory::class, $accountOperationFactory);
    }

    public function testCreateAccountOperation()
    {
        $accountOperationFactory = new AccountOperationFactory();
        $accountOperation = $accountOperationFactory->createAccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
    }

    public function testCreateAccountOperationWithRequired()
    {
        $description = $this->faker->sentence;
        $emailNotifications = $this->faker->randomNumber;
        $smsNotifications = $this->faker->randomNumber;
        $type = $this->faker->randomElement(
            AccountOperation::getTypeFormChoices()
        );
        $accountOperationFactory = new AccountOperationFactory();
        $accountOperation = $accountOperationFactory->createAccountOperationWithRequired(
            $description,
            $emailNotifications,
            $smsNotifications,
            $type
        );
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
        $this->assertEquals($description, $accountOperation->getDescription());
        $this->assertEquals($emailNotifications, $accountOperation->getEmailNotifications());
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertEquals($type, $accountOperation->getType());
    }
}
