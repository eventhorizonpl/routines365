<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\GoalRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

class GoalRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?GoalRepository $goalRepository;
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
        unset($this->goalRepository);
        unset($this->managerRegistry);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $goalRepository = new GoalRepository($this->managerRegistry);

        $this->assertInstanceOf(GoalRepository::class, $goalRepository);
    }

    public function testFindByParametersForAdmin()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $goals = $this->goalRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $goals);
        $this->assertIsArray($goals);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $goals = $this->goalRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $goals);
        $this->assertIsArray($goals);

        $parameters = [
            'query' => 'wrong email',
        ];
        $goals = $this->goalRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $goals);
        $this->assertIsArray($goals);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $goals = $this->goalRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $goals);
        $this->assertIsArray($goals);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $goals = $this->goalRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $goals);
        $this->assertIsArray($goals);
    }
}
