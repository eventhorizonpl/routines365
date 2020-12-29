<?php

declare(strict_types=1);

namespace App\Tests;

use ReflectionObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

abstract class AbstractKernelTestCase extends KernelTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;

    protected static $kernel;

    protected function setUp(): void
    {
        parent::setUp();

        self::$kernel = static::createKernel();
    }

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
