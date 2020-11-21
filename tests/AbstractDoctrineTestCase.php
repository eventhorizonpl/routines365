<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractDoctrineTestCase extends AbstractKernelTestCase
{
    /**
     * @inject
     */
    protected ?EntityManagerInterface $entityManager;

    public function purge()
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }

    protected function tearDown(): void
    {
        $this->entityManager->close();
        $this->entityManager = null;
        unset($this->entityManager);

        parent::tearDown();
    }
}
