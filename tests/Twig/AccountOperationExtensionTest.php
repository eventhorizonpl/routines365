<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\AccountOperationExtension;

/**
 * @internal
 */
final class AccountOperationExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $accountOperationExtension = new AccountOperationExtension();

        $this->assertInstanceOf(AccountOperationExtension::class, $accountOperationExtension);
    }

    public function testGetFunctions(): void
    {
        $accountOperationExtension = new AccountOperationExtension();

        $this->assertCount(1, $accountOperationExtension->getFunctions());
        $this->assertIsArray($accountOperationExtension->getFunctions());
    }

    public function testAccountOperationType(): void
    {
        $accountOperationExtension = new AccountOperationExtension();

        $this->assertCount(2, $accountOperationExtension->accountOperationType());
        $this->assertIsArray($accountOperationExtension->accountOperationType());
    }
}
