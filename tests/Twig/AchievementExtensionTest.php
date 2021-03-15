<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\AchievementExtension;

/**
 * @internal
 * @coversNothing
 */
final class AchievementExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $achievementExtension = new AchievementExtension();

        $this->assertInstanceOf(AchievementExtension::class, $achievementExtension);
    }

    public function testGetFunctions(): void
    {
        $achievementExtension = new AchievementExtension();

        $this->assertCount(1, $achievementExtension->getFunctions());
        $this->assertIsArray($achievementExtension->getFunctions());
    }

    public function testAchievementType(): void
    {
        $achievementExtension = new AchievementExtension();

        $this->assertCount(4, $achievementExtension->achievementType());
        $this->assertIsArray($achievementExtension->achievementType());
    }
}
