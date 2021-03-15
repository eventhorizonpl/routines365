<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use ReflectionObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

abstract class AbstractKernelTestCase extends KernelTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;

    /**
     * @inject
     */
    protected ?EntityManagerInterface $entityManager;

    protected static $kernel;

    protected function setUp(): void
    {
        parent::setUp();

        self::$kernel = static::createKernel();
        $this->entityManager->getConnection()->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->entityManager->getConnection()->rollBack();
        $this->entityManager->close();
        $this->entityManager = null;
        $this->entityManager = null;

        $refl = new ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if ((!($prop->isStatic()))
                && (0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_'))
            ) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
        unset($refl);

        parent::tearDown();
    }
}
