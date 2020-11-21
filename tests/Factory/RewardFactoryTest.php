<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Entity\Reward;
use App\Factory\RewardFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

class RewardFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $rewardFactory = new RewardFactory();

        $this->assertInstanceOf(RewardFactory::class, $rewardFactory);
    }

    public function testCreateReward()
    {
        $rewardFactory = new RewardFactory();
        $reward = $rewardFactory->createReward();
        $this->assertInstanceOf(Reward::class, $reward);
    }

    public function testCreateRewardWithRequired()
    {
        $isAwarded = $this->faker->boolean;
        $name = $this->faker->sentence;
        $requiredNumberOfCompletions = $this->faker->randomNumber;
        $type = $this->faker->randomElement(
            Reward::getTypeFormChoices()
        );
        $rewardFactory = new RewardFactory();
        $reward = $rewardFactory->createRewardWithRequired(
            $isAwarded,
            $name,
            $requiredNumberOfCompletions,
            $type
        );
        $this->assertInstanceOf(Reward::class, $reward);
        $this->assertEquals($isAwarded, $reward->getIsAwarded());
        $this->assertEquals($name, $reward->getName());
        $this->assertEquals($requiredNumberOfCompletions, $reward->getRequiredNumberOfCompletions());
        $this->assertEquals($type, $reward->getType());
    }
}
