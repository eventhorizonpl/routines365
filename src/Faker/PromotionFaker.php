<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Promotion;
use App\Factory\PromotionFactory;
use Faker\Factory;
use Faker\Generator;

class PromotionFaker
{
    private Generator $faker;
    private PromotionFactory $promotionFactory;

    public function __construct(
        PromotionFactory $promotionFactory
    ) {
        $this->faker = Factory::create();
        $this->promotionFactory = $promotionFactory;
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
            $isEnabled = (bool) $this->faker->bool;
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
}
