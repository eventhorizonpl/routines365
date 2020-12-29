<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Achievement;
use App\Factory\AchievementFactory;
use App\Faker\AchievementFaker;
use App\Manager\AchievementManager;
use App\Tests\AbstractDoctrineTestCase;

final class AchievementFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AchievementFactory $achievementFactory;
    /**
     * @inject
     */
    private ?AchievementFaker $achievementFaker;
    /**
     * @inject
     */
    private ?AchievementManager $achievementManager;

    protected function tearDown(): void
    {
        unset($this->achievementFactory);
        unset($this->achievementFaker);
        unset($this->achievementManager);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $achievementFaker = new AchievementFaker($this->achievementFactory, $this->achievementManager);

        $this->assertInstanceOf(AchievementFaker::class, $achievementFaker);
    }

    public function testCreateAchievement(): void
    {
        $this->purge();
        $achievement = $this->achievementFaker->createAchievement();
        $this->assertInstanceOf(Achievement::class, $achievement);
        $isEnabled = true;
        $level = 1;
        $name = 'test name';
        $requirement = 10;
        $type = Achievement::TYPE_COMPLETED_ROUTINE;
        $achievement = $this->achievementFaker->createAchievement(
            $isEnabled,
            $level,
            $name,
            $requirement,
            $type
        );
        $this->assertEquals($isEnabled, $achievement->getIsEnabled());
        $this->assertEquals($level, $achievement->getLevel());
        $this->assertEquals($name, $achievement->getName());
        $this->assertEquals($requirement, $achievement->getRequirement());
        $this->assertEquals($type, $achievement->getType());
    }

    public function testCreateAchievementPersisted(): void
    {
        $this->purge();
        $achievement = $this->achievementFaker->createAchievementPersisted();
        $this->assertInstanceOf(Achievement::class, $achievement);
        $isEnabled = true;
        $level = 1;
        $name = 'test name';
        $requirement = 10;
        $type = Achievement::TYPE_COMPLETED_ROUTINE;
        $achievement = $this->achievementFaker->createAchievementPersisted(
            $isEnabled,
            $level,
            $name,
            $requirement,
            $type
        );
        $this->assertEquals($isEnabled, $achievement->getIsEnabled());
        $this->assertEquals($level, $achievement->getLevel());
        $this->assertEquals($name, $achievement->getName());
        $this->assertEquals($requirement, $achievement->getRequirement());
        $this->assertEquals($type, $achievement->getType());
    }
}
