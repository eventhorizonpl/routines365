<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Reward;
use App\Enum\RewardTypeEnum;
use App\Factory\RewardFactory;
use App\Faker\RewardFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
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
        $this->rewardFactory = null;
        $this->rewardFaker = null
        ;

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
        $isAwarded = false;
        $name = 'test name';
        $numberOfCompletions = 1;
        $requiredNumberOfCompletions = 2;
        $type = RewardTypeEnum::ALL;
        $reward = $this->rewardFaker->createReward(
            $description,
            $isAwarded,
            $name,
            $numberOfCompletions,
            $requiredNumberOfCompletions,
            $type
        );
        $this->assertSame($description, $reward->getDescription());
        $this->assertSame($isAwarded, $reward->getIsAwarded());
        $this->assertSame($name, $reward->getName());
        $this->assertSame($numberOfCompletions, $reward->getNumberOfCompletions());
        $this->assertSame($requiredNumberOfCompletions, $reward->getRequiredNumberOfCompletions());
        $this->assertSame($type, $reward->getType());
    }
}
