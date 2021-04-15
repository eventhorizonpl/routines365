<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Routine;
use App\Factory\RoutineFactory;
use App\Tests\AbstractTestCase;
use Faker\{Factory, Generator};

/**
 * @internal
 */
final class RoutineFactoryTest extends AbstractTestCase
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
        $routineFactory = new RoutineFactory();

        $this->assertInstanceOf(RoutineFactory::class, $routineFactory);
    }

    public function testCreateRoutine(): void
    {
        $routineFactory = new RoutineFactory();
        $routine = $routineFactory->createRoutine();
        $this->assertInstanceOf(Routine::class, $routine);
    }

    public function testCreateRoutineWithRequired(): void
    {
        $isEnabled = $this->faker->boolean();
        $name = $this->faker->sentence();
        $type = $this->faker->randomElement(
            Routine::getTypeFormChoices()
        );
        $routineFactory = new RoutineFactory();
        $routine = $routineFactory->createRoutineWithRequired(
            $isEnabled,
            $name,
            $type
        );
        $this->assertInstanceOf(Routine::class, $routine);
        $this->assertSame($isEnabled, $routine->getIsEnabled());
        $this->assertSame($name, $routine->getName());
        $this->assertSame($type, $routine->getType());
    }
}
