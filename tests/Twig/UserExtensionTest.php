<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\UserExtension;

/**
 * @internal
 * @coversNothing
 */
final class UserExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $userExtension = new UserExtension();

        $this->assertInstanceOf(UserExtension::class, $userExtension);
    }

    public function testGetFunctions(): void
    {
        $userExtension = new UserExtension();

        $this->assertCount(1, $userExtension->getFunctions());
        $this->assertIsArray($userExtension->getFunctions());
    }

    public function testUserType(): void
    {
        $userExtension = new UserExtension();

        $this->assertCount(4, $userExtension->userType());
        $this->assertIsArray($userExtension->userType());
    }
}
