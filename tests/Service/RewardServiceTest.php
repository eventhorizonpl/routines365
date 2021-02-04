<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Reward;
use App\Faker\UserFaker;
use App\Manager\RewardManager;
use App\Repository\RewardRepository;
use App\Service\RewardService;
use App\Tests\AbstractDoctrineTestCase;

final class RewardServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RewardManager $rewardManager;
    /**
     * @inject
     */
    private ?RewardRepository $rewardRepository;
    /**
     * @inject
     */
    private ?RewardService $rewardService;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset(
            $this->rewardManager,
            $this->rewardRepository,
            $this->rewardService,
            $this->userFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $rewardService = new RewardService($this->rewardManager, $this->rewardRepository);

        $this->assertInstanceOf(RewardService::class, $rewardService);
    }

    public function testFindReward(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $routine = $user->getRoutines()->first();
        $reward = $routine->getRewards()->first();
        $isAwarded = $reward->getIsAwarded();

        $type = Reward::TYPE_COMPLETED_ROUTINE;
        $reward->setType($type);

        $this->rewardManager->save($reward);

        $reward = $this->rewardService->findReward($routine, $type);
        if (false === $isAwarded) {
            $this->assertInstanceOf(Reward::class, $reward);
            $this->assertEquals($type, $reward->getType());
        } else {
            $this->assertNull($reward);
        }
    }

    public function testManageReward(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $routine = $user->getRoutines()->first();
        $reward = $routine->getRewards()->first();

        $type = Reward::TYPE_COMPLETED_ROUTINE;
        $isAwarded = false;
        $numberOfCompletions = 0;
        $reward->setType($type);
        $reward->setIsAwarded($isAwarded);
        $reward->setNumberOfCompletions($numberOfCompletions);

        $this->rewardManager->save($reward);

        $reward = $this->rewardService->manageReward($routine, $type);
        $this->assertInstanceOf(Reward::class, $reward);
        $this->assertEquals($type, $reward->getType());
        $this->assertEquals(($numberOfCompletions + 1), $reward->getNumberOfCompletions());
    }
}
