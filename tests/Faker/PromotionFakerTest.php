<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Promotion;
use App\Factory\PromotionFactory;
use App\Faker\PromotionFaker;
use App\Manager\PromotionManager;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class PromotionFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?PromotionFactory $promotionFactory;
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;
    /**
     * @inject
     */
    private ?PromotionManager $promotionManager;

    protected function tearDown(): void
    {
        $this->promotionFactory = null;
        $this->promotionFaker = null;
        $this->promotionManager = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $promotionFaker = new PromotionFaker($this->promotionFactory, $this->promotionManager);

        $this->assertInstanceOf(PromotionFaker::class, $promotionFaker);
    }

    public function testCreatePromotion(): void
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotion();
        $this->assertInstanceOf(Promotion::class, $promotion);
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $notifications = 10;
        $isEnabled = true;
        $name = 'test name';
        $smsNotifications = 10;
        $type = Promotion::TYPE_EXISTING_ACCOUNT;
        $promotion = $this->promotionFaker->createPromotion(
            $code,
            $isEnabled,
            $name,
            $notifications,
            $smsNotifications,
            $type
        );
        $this->assertSame($newCode, $promotion->getCode());
        $this->assertSame($notifications, $promotion->getNotifications());
        $this->assertSame($isEnabled, $promotion->getIsEnabled());
        $this->assertSame($name, $promotion->getName());
        $this->assertSame($smsNotifications, $promotion->getSmsNotifications());
        $this->assertSame($type, $promotion->getType());
    }

    public function testCreatePromotionPersisted(): void
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $this->assertInstanceOf(Promotion::class, $promotion);
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $notifications = 10;
        $isEnabled = true;
        $name = 'test name';
        $smsNotifications = 10;
        $type = Promotion::TYPE_EXISTING_ACCOUNT;
        $promotion = $this->promotionFaker->createPromotionPersisted(
            $code,
            $isEnabled,
            $name,
            $notifications,
            $smsNotifications,
            $type
        );
        $this->assertSame($newCode, $promotion->getCode());
        $this->assertSame($notifications, $promotion->getNotifications());
        $this->assertSame($isEnabled, $promotion->getIsEnabled());
        $this->assertSame($name, $promotion->getName());
        $this->assertSame($smsNotifications, $promotion->getSmsNotifications());
        $this->assertSame($type, $promotion->getType());
    }
}
