<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Reward;
use App\Faker\UserFaker;
use App\Repository\RewardRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 */
final class RewardRepositoryTest extends AbstractDoctrineTestCase
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
        $this->managerRegistry = null;
        $this->rewardRepository = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $rewardRepository = new RewardRepository($this->managerRegistry);

        $this->assertInstanceOf(RewardRepository::class, $rewardRepository);
    }

    public function testFindByParametersForAdmin(): void
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

    public function testFindByParametersForFrontend(): void
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

    public function testFindOneByUserAndTypesAndRoutine(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $reward = $user->getRewards()->first();
        $routine = $user->getRoutines()->first();
        $types = [$reward->getType()->value];

        $rewardResult = $this->rewardRepository->findOneByUserAndTypesAndRoutine($user, $types);
        if (true === $reward->getIsAwarded()) {
            $this->assertNull($rewardResult);
        } else {
            $this->assertInstanceOf(Reward::class, $rewardResult);
        }

        $rewardResult = $this->rewardRepository->findOneByUserAndTypesAndRoutine($user, $types, $routine);
        if (true === $reward->getIsAwarded()) {
            $this->assertNull($rewardResult);
        } else {
            $this->assertInstanceOf(Reward::class, $rewardResult);
        }
    }
}
