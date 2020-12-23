<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\UserKpiExtension;

final class UserKpiExtensionTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $userKpiExtension = new UserKpiExtension();

        $this->assertInstanceOf(UserKpiExtension::class, $userKpiExtension);
    }

    public function testGetFunctions()
    {
        $userKpiExtension = new UserKpiExtension();

        $this->assertCount(1, $userKpiExtension->getFunctions());
        $this->assertIsArray($userKpiExtension->getFunctions());
    }

    public function testUserKpiType()
    {
        $userKpiExtension = new UserKpiExtension();

        $this->assertCount(3, $userKpiExtension->userKpiType());
        $this->assertIsArray($userKpiExtension->userKpiType());
    }
}
