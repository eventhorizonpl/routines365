<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\AccountOperation;
use App\Factory\AccountOperationFactory;
use Faker\Factory;
use Faker\Generator;

class AccountOperationFaker
{
    private Generator $faker;
    private AccountOperationFactory $accountOperationFactory;

    public function __construct(
        AccountOperationFactory $accountOperationFactory
    ) {
        $this->faker = Factory::create();
        $this->accountOperationFactory = $accountOperationFactory;
    }

    public function createAccountOperation(
        ?string $description = null,
        ?int $notifications = null,
        ?int $smsNotifications = null,
        ?string $type = null
    ): AccountOperation {
        if (null === $description) {
            $description = (string) $this->faker->sentence;
        }

        if (null === $notifications) {
            $notifications = (int) $this->faker->numberBetween(10, 100);
        }

        if (null === $smsNotifications) {
            $smsNotifications = (int) $this->faker->numberBetween(10, 100);
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                AccountOperation::getTypeFormChoices()
            );
        }

        $accountOperation = $this->accountOperationFactory->createAccountOperationWithRequired(
            $description,
            $notifications,
            $smsNotifications,
            $type
        );

        return $accountOperation;
    }
}
