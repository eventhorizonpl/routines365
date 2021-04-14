<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Achievement;
use App\Factory\AchievementFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

/**
 * @internal
 * @coversNothing
 */
final class AchievementFactoryTest extends AbstractTestCase
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
        $achievementFactory = new AchievementFactory();

        $this->assertInstanceOf(AchievementFactory::class, $achievementFactory);
    }

    public function testCreateAchievement(): void
    {
        $achievementFactory = new AchievementFactory();
        $achievement = $achievementFactory->createAchievement();
        $this->assertInstanceOf(Achievement::class, $achievement);
    }

    public function testCreateAchievementWithRequired(): void
    {
        $isEnabled = $this->faker->boolean();
        $level = $this->faker->numberBetween(1, 10);
        $name = $this->faker->sentence();
        $requirement = $this->faker->numberBetween(1, 1000);
        $type = $this->faker->randomElement(
            Achievement::getTypeFormChoices()
        );
        $achievementFactory = new AchievementFactory();
        $achievement = $achievementFactory->createAchievementWithRequired(
            $isEnabled,
            $level,
            $name,
            $requirement,
            $type
        );
        $this->assertInstanceOf(Achievement::class, $achievement);
        $this->assertSame($isEnabled, $achievement->getIsEnabled());
        $this->assertSame($level, $achievement->getLevel());
        $this->assertSame($name, $achievement->getName());
        $this->assertSame($requirement, $achievement->getRequirement());
        $this->assertSame($type, $achievement->getType());
    }
}
