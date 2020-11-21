<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Entity\Account;
use App\Factory\AccountFactory;
use App\Tests\AbstractTestCase;

class AccountFactoryTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $accountFactory = new AccountFactory();

        $this->assertInstanceOf(AccountFactory::class, $accountFactory);
    }

    public function testCreateAccount()
    {
        $accountFactory = new AccountFactory();
        $account = $accountFactory->createAccount();
        $this->assertInstanceOf(Account::class, $account);
    }
}
