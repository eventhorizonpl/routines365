<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{Promotion, User};
use App\Enum\PromotionTypeEnum;
use App\Manager\UserManager;
use App\Repository\PromotionRepository;
use DateTimeImmutable;

class PromotionService
{
    public function __construct(
        private AccountOperationService $accountOperationService,
        private PromotionRepository $promotionRepository,
        private UserManager $userManager
    ) {
    }

    public function getEnabledAndValidPromotion(string $code, string $type): ?Promotion
    {
        $promotion = $this->promotionRepository->findOneByCodeAndType(
            $code,
            $type
        );

        $date = new DateTimeImmutable();
        if ((null !== $promotion)
            && (null !== $promotion->getExpiresAt())
            && ($promotion->getExpiresAt() < $date)
        ) {
            return null;
        }

        return $promotion;
    }

    public function applyExistingAccountPromotion(string $code, User $user): ?bool
    {
        $promotion = $this->getEnabledAndValidPromotion(
            $code,
            PromotionTypeEnum::EXISTING_ACCOUNT
        );
        $result = false;

        if (null !== $promotion) {
            $result = $this->applyPromotion($promotion, $user);
        }

        return $result;
    }

    public function applyNewAccountPromotion(string $code, User $user): ?bool
    {
        $promotion = $this->getEnabledAndValidPromotion(
            $code,
            PromotionTypeEnum::NEW_ACCOUNT
        );
        $result = false;

        if (null !== $promotion) {
            $result = $this->applyPromotion($promotion, $user);
        }

        return $result;
    }

    public function applyPromotion(Promotion $promotion, User $user): ?bool
    {
        $saveUser = false;

        if ((PromotionTypeEnum::SYSTEM === $promotion->getType())
            || ((\in_array($promotion->getType(), [PromotionTypeEnum::EXISTING_ACCOUNT, PromotionTypeEnum::NEW_ACCOUNT], true))
            && (false === $user->hasPromotion($promotion)))
        ) {
            $user->addPromotion($promotion);
            $this->accountOperationService->deposit(
                $user->getAccount(),
                sprintf('Deposit for promotion %s %s', $promotion->getCode(), $promotion->getName()),
                $promotion->getNotifications(),
                $promotion->getSmsNotifications(),
                false
            );
            $saveUser = true;
        }

        if (true === $saveUser) {
            $this->userManager->save($user);
        }

        return $saveUser;
    }

    public function applySystemPromotion(string $code, User $user): ?bool
    {
        $promotion = $this->getEnabledAndValidPromotion(
            $code,
            PromotionTypeEnum::SYSTEM
        );

        $result = false;

        if (null !== $promotion) {
            $result = $this->applyPromotion($promotion, $user);
        }

        return $result;
    }
}
