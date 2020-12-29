<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

abstract class AbstractDoctrineTestCase extends AbstractTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;

    /**
     * @inject
     */
    protected ?EntityManagerInterface $entityManager;

    public function purge(): void
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }

    protected function setUp(): void
    {
        parent::setUp();

//        $this->entityManager->getConnection()->beginTransaction();
    }

    protected function tearDown(): void
    {
//        $this->entityManager->getConnection()->rollBack();
        $this->entityManager->close();
        $this->entityManager = null;
        unset($this->entityManager);

        parent::tearDown();
    }
}
