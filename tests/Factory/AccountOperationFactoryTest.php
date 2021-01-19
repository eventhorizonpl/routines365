<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\AccountOperation;
use App\Factory\AccountOperationFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

final class AccountOperationFactoryTest extends AbstractTestCase
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

    public function testConstruct(): void
    {
        $accountOperationFactory = new AccountOperationFactory();

        $this->assertInstanceOf(AccountOperationFactory::class, $accountOperationFactory);
    }

    public function testCreateAccountOperation(): void
    {
        $accountOperationFactory = new AccountOperationFactory();
        $accountOperation = $accountOperationFactory->createAccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
    }

    public function testCreateAccountOperationWithRequired(): void
    {
        $browserNotifications = $this->faker->randomNumber;
        $description = $this->faker->sentence;
        $emailNotifications = $this->faker->randomNumber;
        $smsNotifications = $this->faker->randomNumber;
        $type = $this->faker->randomElement(
            AccountOperation::getTypeFormChoices()
        );
        $accountOperationFactory = new AccountOperationFactory();
        $accountOperation = $accountOperationFactory->createAccountOperationWithRequired(
            $browserNotifications,
            $description,
            $emailNotifications,
            $smsNotifications,
            $type
        );
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
        $this->assertEquals($browserNotifications, $accountOperation->getBrowserNotifications());
        $this->assertEquals($description, $accountOperation->getDescription());
        $this->assertEquals($emailNotifications, $accountOperation->getEmailNotifications());
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertEquals($type, $accountOperation->getType());
    }
}
