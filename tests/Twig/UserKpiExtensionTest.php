<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\UserKpiExtension;

/**
 * @internal
 * @coversNothing
 */
final class UserKpiExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $userKpiExtension = new UserKpiExtension();

        $this->assertInstanceOf(UserKpiExtension::class, $userKpiExtension);
    }

    public function testGetFunctions(): void
    {
        $userKpiExtension = new UserKpiExtension();

        $this->assertCount(1, $userKpiExtension->getFunctions());
        $this->assertIsArray($userKpiExtension->getFunctions());
    }

    public function testUserKpiType(): void
    {
        $userKpiExtension = new UserKpiExtension();

        $this->assertCount(4, $userKpiExtension->userKpiType());
        $this->assertIsArray($userKpiExtension->userKpiType());
    }
}
