<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\RewardExtension;

final class RewardExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $rewardExtension = new RewardExtension();

        $this->assertInstanceOf(RewardExtension::class, $rewardExtension);
    }

    public function testGetFunctions(): void
    {
        $rewardExtension = new RewardExtension();

        $this->assertCount(1, $rewardExtension->getFunctions());
        $this->assertIsArray($rewardExtension->getFunctions());
    }

    public function testRewardType(): void
    {
        $rewardExtension = new RewardExtension();

        $this->assertCount(3, $rewardExtension->rewardType());
        $this->assertIsArray($rewardExtension->rewardType());
    }
}
