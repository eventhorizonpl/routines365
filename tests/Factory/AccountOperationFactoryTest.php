<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\AccountOperation;
use App\Enum\AccountOperationTypeEnum;
use App\Factory\AccountOperationFactory;
use App\Tests\AbstractTestCase;
use Faker\{Factory, Generator};

/**
 * @internal
 */
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
        $this->faker = null;

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
        $description = $this->faker->sentence();
        $notifications = $this->faker->randomNumber();
        $smsNotifications = $this->faker->randomNumber();
        $type = AccountOperationTypeEnum::DEPOSIT;
        $accountOperationFactory = new AccountOperationFactory();
        $accountOperation = $accountOperationFactory->createAccountOperationWithRequired(
            $description,
            $notifications,
            $smsNotifications,
            $type
        );
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
        $this->assertSame($description, $accountOperation->getDescription());
        $this->assertSame($notifications, $accountOperation->getNotifications());
        $this->assertSame($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertSame($type, $accountOperation->getType());
    }
}
