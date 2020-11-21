<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionObject;

abstract class AbstractTestCase extends TestCase
{
    protected function tearDown(): void
    {
        $refl = new ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if ((!($prop->isStatic()))
                and (0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_'))
            ) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }

        parent::tearDown();
    }
}
