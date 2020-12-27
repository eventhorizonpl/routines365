<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Promotion;
use App\Factory\PromotionFactory;
use App\Faker\PromotionFaker;
use App\Manager\PromotionManager;
use App\Tests\AbstractDoctrineTestCase;

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
        unset($this->promotionFactory);
        unset($this->promotionFaker);
        unset($this->promotionManager);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $promotionFaker = new PromotionFaker($this->promotionFactory, $this->promotionManager);

        $this->assertInstanceOf(PromotionFaker::class, $promotionFaker);
    }

    public function testCreatePromotion()
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotion();
        $this->assertInstanceOf(Promotion::class, $promotion);
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $emailNotifications = 10;
        $isEnabled = true;
        $name = 'test name';
        $smsNotifications = 10;
        $type = Promotion::TYPE_EXISTING_ACCOUNT;
        $promotion = $this->promotionFaker->createPromotion(
            $code,
            $emailNotifications,
            $isEnabled,
            $name,
            $smsNotifications,
            $type
        );
        $this->assertEquals($newCode, $promotion->getCode());
        $this->assertEquals($emailNotifications, $promotion->getEmailNotifications());
        $this->assertEquals($isEnabled, $promotion->getIsEnabled());
        $this->assertEquals($name, $promotion->getName());
        $this->assertEquals($smsNotifications, $promotion->getSmsNotifications());
        $this->assertEquals($type, $promotion->getType());
    }

    public function testCreatePromotionPersisted()
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $this->assertInstanceOf(Promotion::class, $promotion);
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $emailNotifications = 10;
        $isEnabled = true;
        $name = 'test name';
        $smsNotifications = 10;
        $type = Promotion::TYPE_EXISTING_ACCOUNT;
        $promotion = $this->promotionFaker->createPromotionPersisted(
            $code,
            $emailNotifications,
            $isEnabled,
            $name,
            $smsNotifications,
            $type
        );
        $this->assertEquals($newCode, $promotion->getCode());
        $this->assertEquals($emailNotifications, $promotion->getEmailNotifications());
        $this->assertEquals($isEnabled, $promotion->getIsEnabled());
        $this->assertEquals($name, $promotion->getName());
        $this->assertEquals($smsNotifications, $promotion->getSmsNotifications());
        $this->assertEquals($type, $promotion->getType());
    }
}