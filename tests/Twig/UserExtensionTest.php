<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Tests\AbstractTestCase;
use App\Twig\UserExtension;

class UserExtensionTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $userExtension = new UserExtension();

        $this->assertInstanceOf(UserExtension::class, $userExtension);
    }

    public function testGetFunctions()
    {
        $userExtension = new UserExtension();

        $this->assertCount(1, $userExtension->getFunctions());
        $this->assertIsArray($userExtension->getFunctions());
    }

    public function testUserType()
    {
        $userExtension = new UserExtension();

        $this->assertCount(4, $userExtension->userType());
        $this->assertIsArray($userExtension->userType());
    }
}
