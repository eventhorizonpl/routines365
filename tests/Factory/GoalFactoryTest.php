<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Goal;
use App\Factory\GoalFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

final class GoalFactoryTest extends AbstractTestCase
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
        $goalFactory = new GoalFactory();

        $this->assertInstanceOf(GoalFactory::class, $goalFactory);
    }

    public function testCreateGoal()
    {
        $goalFactory = new GoalFactory();
        $goal = $goalFactory->createGoal();
        $this->assertInstanceOf(Goal::class, $goal);
    }

    public function testCreateGoalWithRequired()
    {
        $isCompleted = $this->faker->boolean;
        $name = $this->faker->sentence;
        $goalFactory = new GoalFactory();
        $goal = $goalFactory->createGoalWithRequired(
            $isCompleted,
            $name
        );
        $this->assertInstanceOf(Goal::class, $goal);
        $this->assertEquals($isCompleted, $goal->getIsCompleted());
        $this->assertEquals($name, $goal->getName());
    }
}
