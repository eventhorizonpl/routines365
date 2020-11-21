<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Entity\CompletedRoutine;
use App\Factory\CompletedRoutineFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

class CompletedRoutineFactoryTest extends AbstractTestCase
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
        $completedRoutineFactory = new CompletedRoutineFactory();

        $this->assertInstanceOf(CompletedRoutineFactory::class, $completedRoutineFactory);
    }

    public function testCreateCompletedRoutine()
    {
        $completedRoutineFactory = new CompletedRoutineFactory();
        $completedRoutine = $completedRoutineFactory->createCompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine);
    }

    public function testCreateCompletedRoutineWithRequired()
    {
        $minutesDevoted = $this->faker->randomNumber;
        $completedRoutineFactory = new CompletedRoutineFactory();
        $completedRoutine = $completedRoutineFactory->createCompletedRoutineWithRequired(
            $minutesDevoted
        );
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine);
        $this->assertEquals($minutesDevoted, $completedRoutine->getMinutesDevoted());
    }
}
