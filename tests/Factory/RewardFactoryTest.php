<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Reward;
use App\Factory\RewardFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

final class RewardFactoryTest extends AbstractTestCase
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

    public function testConstruct(): void
    {
        $rewardFactory = new RewardFactory();

        $this->assertInstanceOf(RewardFactory::class, $rewardFactory);
    }

    public function testCreateReward(): void
    {
        $rewardFactory = new RewardFactory();
        $reward = $rewardFactory->createReward();
        $this->assertInstanceOf(Reward::class, $reward);
    }

    public function testCreateRewardWithRequired(): void
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
