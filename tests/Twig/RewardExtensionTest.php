<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Tests\AbstractTestCase;
use App\Twig\RewardExtension;

class RewardExtensionTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $rewardExtension = new RewardExtension();

        $this->assertInstanceOf(RewardExtension::class, $rewardExtension);
    }

    public function testGetFunctions()
    {
        $rewardExtension = new RewardExtension();

        $this->assertCount(1, $rewardExtension->getFunctions());
        $this->assertIsArray($rewardExtension->getFunctions());
    }

    public function testRewardType()
    {
        $rewardExtension = new RewardExtension();

        $this->assertCount(3, $rewardExtension->rewardType());
        $this->assertIsArray($rewardExtension->rewardType());
    }
}
