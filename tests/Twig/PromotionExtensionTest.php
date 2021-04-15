<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\PromotionExtension;

/**
 * @internal
 */
final class PromotionExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $promotionExtension = new PromotionExtension();

        $this->assertInstanceOf(PromotionExtension::class, $promotionExtension);
    }

    public function testGetFunctions(): void
    {
        $promotionExtension = new PromotionExtension();

        $this->assertCount(1, $promotionExtension->getFunctions());
        $this->assertIsArray($promotionExtension->getFunctions());
    }

    public function testPromotionType(): void
    {
        $promotionExtension = new PromotionExtension();

        $this->assertCount(3, $promotionExtension->promotionType());
        $this->assertIsArray($promotionExtension->promotionType());
    }
}
