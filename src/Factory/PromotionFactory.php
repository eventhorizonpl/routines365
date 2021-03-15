<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Promotion;
use Symfony\Component\Uid\Uuid;

class PromotionFactory
{
    public function createPromotion(): Promotion
    {
        $promotion = new Promotion();
        $promotion->setUuid((string) Uuid::v4());

        return $promotion;
    }

    public function createPromotionWithRequired(
        string $code,
        bool $isEnabled,
        string $name,
        int $notifications,
        int $smsNotifications,
        string $type
    ): Promotion {
        $promotion = $this->createPromotion();

        $promotion
            ->setCode($code)
            ->setIsEnabled($isEnabled)
            ->setName($name)
            ->setNotifications($notifications)
            ->setSmsNotifications($smsNotifications)
            ->setType($type)
        ;

        return $promotion;
    }
}
