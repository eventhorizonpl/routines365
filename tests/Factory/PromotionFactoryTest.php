<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Promotion;
use App\Factory\PromotionFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

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
        unset($this->faker);

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
        $code = $this->faker->sentence;
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $notifications = $this->faker->numberBetween(1, 10);
        $isEnabled = $this->faker->boolean;
        $name = $this->faker->sentence;
        $smsNotifications = $this->faker->numberBetween(1, 10);
        $type = $this->faker->randomElement(
            Promotion::getTypeFormChoices()
        );
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
        $this->assertEquals($newCode, $promotion->getCode());
        $this->assertEquals($notifications, $promotion->getNotifications());
        $this->assertEquals($isEnabled, $promotion->getIsEnabled());
        $this->assertEquals($name, $promotion->getName());
        $this->assertEquals($smsNotifications, $promotion->getSmsNotifications());
        $this->assertEquals($type, $promotion->getType());
    }
}
