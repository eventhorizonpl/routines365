<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\User;
use App\Faker\UserFaker;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionObject;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Panther\PantherTestCase;
use Zalas\Injector\PHPUnit\Symfony\TestCase\SymfonyTestContainer;
use Zalas\Injector\PHPUnit\TestCase\ServiceContainerTestCase;

abstract class AbstractUiTestCase extends PantherTestCase implements ServiceContainerTestCase
{
    use SymfonyTestContainer;

    protected ?KernelBrowser $client;

    /**
     * @inject
     */
    protected ?EntityManagerInterface $entityManager;

    /**
     * @inject
     */
    protected ?UserFaker $userFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->client->followRedirects();
    }

    public function createAndLoginAdmin(): User
    {
        $user = $this->userFaker->createAdminUserPersisted();
        $this->client->loginUser($user);

        return $user;
    }

    public function createAndLoginRegular(): User
    {
        $user = $this->createRegular();
        $this->client->loginUser($user);

        return $user;
    }

    public function createAndLoginRich(): User
    {
        $user = $this->createRich();
        $this->client->loginUser($user);

        return $user;
    }

    public function createRegular(): User
    {
        return $this->userFaker->createCustomerUserPersisted();
    }

    public function createRich(): User
    {
        return $this->userFaker->createRichUserPersisted();
    }

    public function purge(): void
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }

    protected function tearDown(): void
    {
        $this->purge();
        $this->entityManager->close();
        $this->entityManager = null;

        $this->client = null;
        $this->userFaker = null;

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
