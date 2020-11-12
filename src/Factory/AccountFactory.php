<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Account;
use Symfony\Component\Uid\Uuid;

class AccountFactory
{
    public function createAccount(): Account
    {
        $account = new Account();
        $account->setUuid(Uuid::v4());

        return $account;
    }
}
