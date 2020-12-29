<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionObject;
use Symfony\Component\Form\Test\TypeTestCase;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

abstract class AbstractTypeDoctrineTestCase extends TypeTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;

    /**
     * @inject
     */
    protected ?EntityManagerInterface $entityManager;

    public function purge(): void
    {
        //$purger = new ORMPurger($this->entityManager);
        //$purger->purge();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManager->getConnection()->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->entityManager->getConnection()->rollBack();
        $this->entityManager->close();
        $this->entityManager = null;
        unset($this->entityManager);

        $refl = new ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if ((!($prop->isStatic())) &&
                (0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_'))
            ) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }
        unset($refl);

        parent::tearDown();
    }
}
