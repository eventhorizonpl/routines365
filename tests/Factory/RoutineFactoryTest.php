<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Entity\Routine;
use App\Factory\RoutineFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

class RoutineFactoryTest extends AbstractTestCase
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
        $routineFactory = new RoutineFactory();

        $this->assertInstanceOf(RoutineFactory::class, $routineFactory);
    }

    public function testCreateRoutine()
    {
        $routineFactory = new RoutineFactory();
        $routine = $routineFactory->createRoutine();
        $this->assertInstanceOf(Routine::class, $routine);
    }

    public function testCreateRoutineWithRequired()
    {
        $isEnabled = $this->faker->boolean;
        $name = $this->faker->sentence;
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
        $this->assertEquals($isEnabled, $routine->getIsEnabled());
        $this->assertEquals($name, $routine->getName());
        $this->assertEquals($type, $routine->getType());
    }
}
