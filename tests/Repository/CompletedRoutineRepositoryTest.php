<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\CompletedRoutineRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 */
final class CompletedRoutineRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?CompletedRoutineRepository $completedRoutineRepository;
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->completedRoutineRepository = null;
        $this->managerRegistry = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $completedRoutineRepository = new CompletedRoutineRepository($this->managerRegistry);

        $this->assertInstanceOf(CompletedRoutineRepository::class, $completedRoutineRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $completedRoutines = $this->completedRoutineRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $completedRoutines);
        $this->assertIsArray($completedRoutines);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $completedRoutines = $this->completedRoutineRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $completedRoutines);
        $this->assertIsArray($completedRoutines);

        $parameters = [
            'query' => 'wrong email',
        ];
        $completedRoutines = $this->completedRoutineRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $completedRoutines);
        $this->assertIsArray($completedRoutines);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $completedRoutines = $this->completedRoutineRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $completedRoutines);
        $this->assertIsArray($completedRoutines);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $completedRoutines = $this->completedRoutineRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $completedRoutines);
        $this->assertIsArray($completedRoutines);
    }
}
