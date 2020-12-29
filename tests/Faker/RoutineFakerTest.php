<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Routine;
use App\Factory\RoutineFactory;
use App\Faker\RoutineFaker;
use App\Tests\AbstractDoctrineTestCase;

final class RoutineFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?RoutineFactory $routineFactory;
    /**
     * @inject
     */
    private ?RoutineFaker $routineFaker;

    protected function tearDown(): void
    {
        unset(
            $this->routineFactory,
            $this->routineFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $routineFaker = new RoutineFaker($this->routineFactory);

        $this->assertInstanceOf(RoutineFaker::class, $routineFaker);
    }

    public function testCreateRoutine(): void
    {
        $this->purge();
        $routine = $this->routineFaker->createRoutine();
        $this->assertInstanceOf(Routine::class, $routine);
        $description = 'test description';
        $isEnabled = true;
        $name = 'test name';
        $type = Routine::TYPE_HOBBY;
        $routine = $this->routineFaker->createRoutine(
            $description,
            $isEnabled,
            $name,
            $type
        );
        $this->assertEquals($description, $routine->getDescription());
        $this->assertEquals($isEnabled, $routine->getIsEnabled());
        $this->assertEquals($name, $routine->getName());
        $this->assertEquals($type, $routine->getType());
    }
}
