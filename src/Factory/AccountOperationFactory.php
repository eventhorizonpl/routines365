<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AccountOperation;
use App\Enum\AccountOperationTypeEnum;
use Symfony\Component\Uid\Uuid;

class AccountOperationFactory
{
    public function createAccountOperation(): AccountOperation
    {
        $accountOperation = new AccountOperation();
        $accountOperation->setUuid((string) Uuid::v4());

        return $accountOperation;
    }

    public function createAccountOperationWithRequired(
        string $description,
        int $notifications,
        int $smsNotifications,
        AccountOperationTypeEnum $type
    ): AccountOperation {
        $accountOperation = $this->createAccountOperation();

        $accountOperation
            ->setDescription($description)
            ->setNotifications($notifications)
            ->setSmsNotifications($smsNotifications)
            ->setType($type)
        ;

        return $accountOperation;
    }
}
