<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\RoutineExtension;

/**
 * @internal
 * @coversNothing
 */
final class RoutineExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $routineExtension = new RoutineExtension();

        $this->assertInstanceOf(RoutineExtension::class, $routineExtension);
    }

    public function testGetFunctions(): void
    {
        $routineExtension = new RoutineExtension();

        $this->assertCount(1, $routineExtension->getFunctions());
        $this->assertIsArray($routineExtension->getFunctions());
    }

    public function testRoutineType(): void
    {
        $routineExtension = new RoutineExtension();

        $this->assertCount(4, $routineExtension->routineType());
        $this->assertIsArray($routineExtension->routineType());
    }
}
