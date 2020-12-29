<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Account;
use App\Factory\AccountFactory;
use App\Tests\AbstractTestCase;

final class AccountFactoryTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $accountFactory = new AccountFactory();

        $this->assertInstanceOf(AccountFactory::class, $accountFactory);
    }

    public function testCreateAccount(): void
    {
        $accountFactory = new AccountFactory();
        $account = $accountFactory->createAccount();
        $this->assertInstanceOf(Account::class, $account);
    }
}
