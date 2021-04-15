<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Routine;
use App\Factory\RoutineFactory;
use App\Faker\RoutineFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
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
        $this->routineFactory = null;
        $this->routineFaker = null
        ;

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
        $this->assertSame($description, $routine->getDescription());
        $this->assertSame($isEnabled, $routine->getIsEnabled());
        $this->assertSame($name, $routine->getName());
        $this->assertSame($type, $routine->getType());
    }
}
