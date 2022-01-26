<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\AccountOperation;
use App\Enum\AccountOperationTypeEnum;
use App\Factory\AccountOperationFactory;
use Faker\{Factory, Generator};

class AccountOperationFaker
{
    private Generator $faker;

    public function __construct(
        private AccountOperationFactory $accountOperationFactory
    ) {
        $this->faker = Factory::create();
    }

    public function createAccountOperation(
        ?string $description = null,
        ?int $notifications = null,
        ?int $smsNotifications = null,
        ?AccountOperationTypeEnum $type = null
    ): AccountOperation {
        if (null === $description) {
            $description = (string) $this->faker->sentence();
        }

        if (null === $notifications) {
            $notifications = (int) $this->faker->numberBetween(10, 100);
        }

        if (null === $smsNotifications) {
            $smsNotifications = (int) $this->faker->numberBetween(10, 100);
        }

        if (null === $type) {
            $type = AccountOperationTypeEnum::DEPOSIT;
        }

        return $this->accountOperationFactory->createAccountOperationWithRequired(
            $description,
            $notifications,
            $smsNotifications,
            $type
        );
    }
}
