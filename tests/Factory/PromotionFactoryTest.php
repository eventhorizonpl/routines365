<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Promotion;
use App\Enum\PromotionTypeEnum;
use App\Factory\PromotionFactory;
use App\Tests\AbstractTestCase;
use Faker\{Factory, Generator};

/**
 * @internal
 */
final class PromotionFactoryTest extends AbstractTestCase
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
        $promotionFactory = new PromotionFactory();

        $this->assertInstanceOf(PromotionFactory::class, $promotionFactory);
    }

    public function testCreatePromotion(): void
    {
        $promotionFactory = new PromotionFactory();
        $promotion = $promotionFactory->createPromotion();
        $this->assertInstanceOf(Promotion::class, $promotion);
    }

    public function testCreatePromotionWithRequired(): void
    {
        $code = $this->faker->sentence();
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $notifications = $this->faker->numberBetween(1, 10);
        $isEnabled = $this->faker->boolean();
        $name = $this->faker->sentence();
        $smsNotifications = $this->faker->numberBetween(1, 10);
        $type = PromotionTypeEnum::EXISTING_ACCOUNT;
        $promotionFactory = new PromotionFactory();
        $promotion = $promotionFactory->createPromotionWithRequired(
            $code,
            $isEnabled,
            $name,
            $notifications,
            $smsNotifications,
            $type
        );
        $this->assertInstanceOf(Promotion::class, $promotion);
        $this->assertSame($newCode, $promotion->getCode());
        $this->assertSame($notifications, $promotion->getNotifications());
        $this->assertSame($isEnabled, $promotion->getIsEnabled());
        $this->assertSame($name, $promotion->getName());
        $this->assertSame($smsNotifications, $promotion->getSmsNotifications());
        $this->assertSame($type, $promotion->getType());
    }
}
