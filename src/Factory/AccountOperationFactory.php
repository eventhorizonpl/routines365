<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\AccountOperation;
use Symfony\Component\Uid\Uuid;

class AccountOperationFactory
{
    public function createAccountOperation(): AccountOperation
    {
        $accountOperation = new AccountOperation();
        $accountOperation->setUuid(Uuid::v4());

        return $accountOperation;
    }

    public function createAccountOperationWithRequired(
        string $description,
        int $emailNotifications,
        int $smsNotifications,
        string $type
    ): AccountOperation {
        $accountOperation = $this->createAccountOperation();

        $accountOperation
            ->setDescription($description)
            ->setEmailNotifications($emailNotifications)
            ->setSmsNotifications($smsNotifications)
            ->setType($type);

        return $accountOperation;
    }
}
