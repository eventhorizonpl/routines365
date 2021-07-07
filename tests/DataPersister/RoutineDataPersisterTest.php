<?php

declare(strict_types=1);

namespace App\Tests\DataPersister;

use App\DataPersister\RoutineDataPersister;
use App\Entity\Routine;
use App\Faker\UserFaker;
use App\Manager\RoutineManager;
use App\Repository\RoutineRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Security\Core\Security;

/**
 * @internal
 */
final class RoutineDataPersisterTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RoutineDataPersister $routineDataPersister;
    /**
     * @inject
     */
    private ?RoutineManager $routineManager;
    /**
     * @inject
     */
    private ?RoutineRepository $routineRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?Security $security;

    protected function tearDown(): void
    {
        $this->routineDataPersister = null;
        $this->routineManager = null;
        $this->routineRepository = null;
        $this->userFaker = null;
        $this->security = null;

        parent::tearDown();
    }

    public function createRoutine(): Routine
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getRoutines()->first();
    }

    public function testConstruct(): void
    {
        $routineDataPersister = new RoutineDataPersister($this->routineManager, $this->security);

        $this->assertInstanceOf(RoutineDataPersister::class, $routineDataPersister);
    }

    public function testSupports(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();

        $this->assertTrue($this->routineDataPersister->supports($routine));
        $this->assertFalse($this->routineDataPersister->supports($user));
    }

    public function testPersist(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();

        $security = $this->createStub(Security::class);
        $security->method('getUser')
            ->willReturn($user)
        ;

        $routineDataPersister = new RoutineDataPersister($this->routineManager, $security);

        $this->assertInstanceOf(Routine::class, $routineDataPersister->persist($routine));
    }

    public function testRemove(): void
    {
        $this->purge();
        $routine = $this->createRoutine();
        $user = $routine->getUser();
        $routineId = $routine->getId();

        $security = $this->createStub(Security::class);
        $security->method('getUser')
            ->willReturn($user)
        ;

        $routineDataPersister = new RoutineDataPersister($this->routineManager, $security);

        $this->assertNull($routineDataPersister->remove($routine));

        $routine2 = $this->routineRepository->findOneById($routineId);
        $this->assertInstanceOf(Routine::class, $routine2);
        $this->assertTrue(null !== $routine2->getDeletedAt());
    }
}
