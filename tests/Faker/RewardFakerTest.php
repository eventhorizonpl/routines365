<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Reward;
use App\Factory\RewardFactory;
use App\Faker\RewardFaker;
use App\Tests\AbstractDoctrineTestCase;

final class RewardFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RewardFactory $rewardFactory;
    /**
     * @inject
     */
    private ?RewardFaker $rewardFaker;

    protected function tearDown(): void
    {
        unset($this->rewardFactory);
        unset($this->rewardFaker);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $rewardFaker = new RewardFaker($this->rewardFactory);

        $this->assertInstanceOf(RewardFaker::class, $rewardFaker);
    }

    public function testCreateReward(): void
    {
        $this->purge();
        $reward = $this->rewardFaker->createReward();
        $this->assertInstanceOf(Reward::class, $reward);
        $description = 'test description';
        $isAwarded = true;
        $name = 'test name';
        $numberOfCompletions = 1;
        $requiredNumberOfCompletions = 2;
        $type = Reward::TYPE_ALL;
        $reward = $this->rewardFaker->createReward(
            $description,
            $isAwarded,
            $name,
            $numberOfCompletions,
            $requiredNumberOfCompletions,
            $type
        );
        $this->assertEquals($description, $reward->getDescription());
        $this->assertEquals($isAwarded, $reward->getIsAwarded());
        $this->assertEquals($name, $reward->getName());
        $this->assertEquals($numberOfCompletions, $reward->getNumberOfCompletions());
        $this->assertEquals($requiredNumberOfCompletions, $reward->getRequiredNumberOfCompletions());
        $this->assertEquals($type, $reward->getType());
    }
}
