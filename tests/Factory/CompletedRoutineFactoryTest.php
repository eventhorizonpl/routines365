<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\CompletedRoutine;
use App\Factory\CompletedRoutineFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

/**
 * @internal
 * @coversNothing
 */
final class CompletedRoutineFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        $this->faker = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $completedRoutineFactory = new CompletedRoutineFactory();

        $this->assertInstanceOf(CompletedRoutineFactory::class, $completedRoutineFactory);
    }

    public function testCreateCompletedRoutine(): void
    {
        $completedRoutineFactory = new CompletedRoutineFactory();
        $completedRoutine = $completedRoutineFactory->createCompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine);
    }

    public function testCreateCompletedRoutineWithRequired(): void
    {
        $minutesDevoted = $this->faker->randomNumber();
        $completedRoutineFactory = new CompletedRoutineFactory();
        $completedRoutine = $completedRoutineFactory->createCompletedRoutineWithRequired(
            $minutesDevoted
        );
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine);
        $this->assertSame($minutesDevoted, $completedRoutine->getMinutesDevoted());
    }
}
