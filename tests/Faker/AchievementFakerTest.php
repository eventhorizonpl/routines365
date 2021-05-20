<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Achievement;
use App\Enum\AchievementTypeEnum;
use App\Factory\AchievementFactory;
use App\Faker\AchievementFaker;
use App\Manager\AchievementManager;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
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
        $this->achievementFactory = null;
        $this->achievementFaker = null;
        $this->achievementManager = null
        ;

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
        $type = AchievementTypeEnum::COMPLETED_ROUTINE;
        $achievement = $this->achievementFaker->createAchievement(
            $isEnabled,
            $level,
            $name,
            $requirement,
            $type
        );
        $this->assertSame($isEnabled, $achievement->getIsEnabled());
        $this->assertSame($level, $achievement->getLevel());
        $this->assertSame($name, $achievement->getName());
        $this->assertSame($requirement, $achievement->getRequirement());
        $this->assertSame($type, $achievement->getType());
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
        $type = AchievementTypeEnum::COMPLETED_ROUTINE;
        $achievement = $this->achievementFaker->createAchievementPersisted(
            $isEnabled,
            $level,
            $name,
            $requirement,
            $type
        );
        $this->assertSame($isEnabled, $achievement->getIsEnabled());
        $this->assertSame($level, $achievement->getLevel());
        $this->assertSame($name, $achievement->getName());
        $this->assertSame($requirement, $achievement->getRequirement());
        $this->assertSame($type, $achievement->getType());
    }
}
