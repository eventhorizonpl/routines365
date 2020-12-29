<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Goal;
use App\Factory\GoalFactory;
use App\Faker\GoalFaker;
use App\Tests\AbstractDoctrineTestCase;

final class GoalFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?GoalFactory $goalFactory;
    /**
     * @inject
     */
    private ?GoalFaker $goalFaker;

    protected function tearDown(): void
    {
        unset(
            $this->goalFactory,
            $this->goalFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $goalFaker = new GoalFaker($this->goalFactory);

        $this->assertInstanceOf(GoalFaker::class, $goalFaker);
    }

    public function testCreateGoal(): void
    {
        $this->purge();
        $goal = $this->goalFaker->createGoal();
        $this->assertInstanceOf(Goal::class, $goal);
        $description = 'test description';
        $isCompleted = true;
        $name = 'test name';
        $goal = $this->goalFaker->createGoal(
            $description,
            $isCompleted,
            $name
        );
        $this->assertEquals($description, $goal->getDescription());
        $this->assertEquals($isCompleted, $goal->getIsCompleted());
        $this->assertEquals($name, $goal->getName());
    }
}
