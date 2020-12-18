<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\RoutineRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

final class RoutineRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?RoutineRepository $routineRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset($this->managerRegistry);
        unset($this->routineRepository);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $routineRepository = new RoutineRepository($this->managerRegistry);

        $this->assertInstanceOf(RoutineRepository::class, $routineRepository);
    }

    public function testFindByParametersForAdmin()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $routines = $this->routineRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $routines);
        $this->assertIsArray($routines);

        $parameters = [
            'type' => 'wrong',
        ];
        $routines = $this->routineRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $routines);
        $this->assertIsArray($routines);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $routines = $this->routineRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $routines);
        $this->assertIsArray($routines);

        $parameters = [
            'query' => 'wrong email',
        ];
        $routines = $this->routineRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $routines);
        $this->assertIsArray($routines);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $routines = $this->routineRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $routines);
        $this->assertIsArray($routines);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $routines = $this->routineRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $routines);
        $this->assertIsArray($routines);
    }

    public function testFindByParametersForFrontend()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $routine = $user->getRoutines()->first();

        $routines = $this->routineRepository->findByParametersForFrontend($user);
        $this->assertCount(1, $routines);
        $this->assertIsArray($routines);

        $parameters = [
            'type' => 'wrong',
        ];
        $routines = $this->routineRepository->findByParametersForFrontend($user, $parameters);
        $this->assertCount(0, $routines);
        $this->assertIsArray($routines);

        $parameters = [
            'query' => $routine->getDescription(),
        ];
        $routines = $this->routineRepository->findByParametersForFrontend($user, $parameters);
        $this->assertCount(1, $routines);
        $this->assertIsArray($routines);

        $parameters = [
            'query' => 'wrong email',
        ];
        $routines = $this->routineRepository->findByParametersForFrontend($user, $parameters);
        $this->assertCount(0, $routines);
        $this->assertIsArray($routines);
    }
}
