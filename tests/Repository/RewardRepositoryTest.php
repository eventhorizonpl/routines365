<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Reward;
use App\Faker\UserFaker;
use App\Repository\RewardRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

class RewardRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?RewardRepository $rewardRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset($this->managerRegistry);
        unset($this->rewardRepository);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $rewardRepository = new RewardRepository($this->managerRegistry);

        $this->assertInstanceOf(RewardRepository::class, $rewardRepository);
    }

    public function testFindByParametersForAdmin()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $rewards = $this->rewardRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $rewards);
        $this->assertIsArray($rewards);

        $parameters = [
            'type' => 'wrong',
        ];
        $rewards = $this->rewardRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $rewards);
        $this->assertIsArray($rewards);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $rewards = $this->rewardRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $rewards);
        $this->assertIsArray($rewards);

        $parameters = [
            'query' => 'wrong email',
        ];
        $rewards = $this->rewardRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $rewards);
        $this->assertIsArray($rewards);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $rewards = $this->rewardRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $rewards);
        $this->assertIsArray($rewards);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $rewards = $this->rewardRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $rewards);
        $this->assertIsArray($rewards);
    }

    public function testFindByParametersForFrontend()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reward = $user->getRewards()->first();

        $rewards = $this->rewardRepository->findByParametersForFrontend($user)->getResult();
        $this->assertCount(1, $rewards);
        $this->assertIsArray($rewards);

        $parameters = [
            'query' => $reward->getName(),
        ];
        $rewards = $this->rewardRepository->findByParametersForFrontend($user, $parameters)->getResult();
        $this->assertCount(1, $rewards);
        $this->assertIsArray($rewards);

        $parameters = [
            'query' => 'wrong email',
        ];
        $rewards = $this->rewardRepository->findByParametersForFrontend($user, $parameters)->getResult();
        $this->assertCount(0, $rewards);
        $this->assertIsArray($rewards);
    }

    public function testFindOneByUserAndTypesAndRoutine()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reward = $user->getRewards()->first();
        $routine = $user->getRoutines()->first();
        $types = [$reward->getType()];

        $rewardResult = $this->rewardRepository->findOneByUserAndTypesAndRoutine($user, $types);
        if (true === $reward->getIsAwarded()) {
            $this->assertEquals(null, $rewardResult);
        } else {
            $this->assertInstanceOf(Reward::class, $rewardResult);
        }

        $rewardResult = $this->rewardRepository->findOneByUserAndTypesAndRoutine($user, $types, $routine);
        $this->assertEquals(null, $rewardResult);
    }
}