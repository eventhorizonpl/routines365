<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Promotion;
use App\Factory\PromotionFactory;
use App\Manager\PromotionManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class PromotionFaker
{
    private Generator $faker;
    private PromotionFactory $promotionFactory;
    private PromotionManager $promotionManager;

    public function __construct(
        PromotionFactory $promotionFactory,
        PromotionManager $promotionManager
    ) {
        $this->faker = Factory::create();
        $this->promotionFactory = $promotionFactory;
        $this->promotionManager = $promotionManager;
    }

    public function createPromotion(
        ?string $code = null,
        ?int $emailNotifications = null,
        ?bool $isEnabled = null,
        ?string $name = null,
        ?int $smsNotifications = null,
        ?string $type = null
    ): Promotion {
        if (null === $code) {
            $code = (string) $this->faker->word;
        }

        if (null === $emailNotifications) {
            $emailNotifications = (int) $this->faker->numberBetween(1, 10);
        }

        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean;
        }

        if (null === $name) {
            $name = (string) $this->faker->text(64);
        }

        if (null === $smsNotifications) {
            $smsNotifications = (int) $this->faker->numberBetween(1, 10);
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Promotion::getTypeValidationChoices()
            );
        }

        $promotion = $this->promotionFactory->createPromotionWithRequired(
            $code,
            $emailNotifications,
            $isEnabled,
            $name,
            $smsNotifications,
            $type
        );

        return $promotion;
    }

    public function createPromotionPersisted(
        ?string $code = null,
        ?int $emailNotifications = null,
        ?bool $isEnabled = null,
        ?string $name = null,
        ?int $smsNotifications = null,
        ?string $type = null
    ): Promotion {
        $promotion = $this->createPromotion(
            $code,
            $emailNotifications,
            $isEnabled,
            $name,
            $smsNotifications,
            $type
        );
        $this->promotionManager->save($promotion, (string) Uuid::v4());

        return $promotion;
    }
}
