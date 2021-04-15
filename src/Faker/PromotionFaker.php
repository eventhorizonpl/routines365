<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Promotion;
use App\Factory\PromotionFactory;
use App\Manager\PromotionManager;
use Faker\{Factory, Generator};
use Symfony\Component\Uid\Uuid;

class PromotionFaker
{
    private Generator $faker;

    public function __construct(
        private PromotionFactory $promotionFactory,
        private PromotionManager $promotionManager
    ) {
        $this->faker = Factory::create();
    }

    public function createPromotion(
        ?string $code = null,
        ?bool $isEnabled = null,
        ?string $name = null,
        ?int $notifications = null,
        ?int $smsNotifications = null,
        ?string $type = null
    ): Promotion {
        if (null === $code) {
            $code = (string) $this->faker->word();
        }

        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean();
        }

        if (null === $name) {
            $name = (string) $this->faker->text(64);
        }

        if (null === $notifications) {
            $notifications = (int) $this->faker->numberBetween(1, 10);
        }

        if (null === $smsNotifications) {
            $smsNotifications = (int) $this->faker->numberBetween(1, 10);
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Promotion::getTypeValidationChoices()
            );
        }

        return $this->promotionFactory->createPromotionWithRequired(
            $code,
            $isEnabled,
            $name,
            $notifications,
            $smsNotifications,
            $type
        );
    }

    public function createPromotionPersisted(
        ?string $code = null,
        ?bool $isEnabled = null,
        ?string $name = null,
        ?int $notifications = null,
        ?int $smsNotifications = null,
        ?string $type = null
    ): Promotion {
        $promotion = $this->createPromotion(
            $code,
            $isEnabled,
            $name,
            $notifications,
            $smsNotifications,
            $type
        );
        $this->promotionManager->save($promotion, (string) Uuid::v4());

        return $promotion;
    }
}
