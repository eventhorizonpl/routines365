<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\RoutineExtension;

final class RoutineExtensionTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $routineExtension = new RoutineExtension();

        $this->assertInstanceOf(RoutineExtension::class, $routineExtension);
    }

    public function testGetFunctions()
    {
        $routineExtension = new RoutineExtension();

        $this->assertCount(1, $routineExtension->getFunctions());
        $this->assertIsArray($routineExtension->getFunctions());
    }

    public function testRoutineType()
    {
        $routineExtension = new RoutineExtension();

        $this->assertCount(4, $routineExtension->routineType());
        $this->assertIsArray($routineExtension->routineType());
    }
}
