<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Promotion;
use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\PromotionRepository;
use DateTimeImmutable;

class PromotionService
{
    private AccountOperationService $accountOperationService;
    private PromotionRepository $promotionRepository;
    private UserManager $userManager;

    public function __construct(
        AccountOperationService $accountOperationService,
        PromotionRepository $promotionRepository,
        UserManager $userManager
    ) {
        $this->accountOperationService = $accountOperationService;
        $this->promotionRepository = $promotionRepository;
        $this->userManager = $userManager;
    }

    public function getEnabledAndValidPromotion(string $code, string $type): ?Promotion
    {
        $promotion = $this->promotionRepository->findOneByCodeAndType(
            $code,
            $type
        );

        $date = new DateTimeImmutable();
        if ((null !== $promotion) &&
            (null !== $promotion->getExpiresAt()) &&
            ($promotion->getExpiresAt() < $date)
        ) {
            return null;
        }

        return $promotion;
    }

    public function applyExistingAccountPromotion(string $code, User $user): bool
    {
        $promotion = $this->getEnabledAndValidPromotion(
            $code,
            Promotion::TYPE_EXISTING_ACCOUNT
        );
        $result = false;

        if (null !== $promotion) {
            $result = $this->applyPromotion($promotion, $user);
        }

        return $result;
    }

    public function applyNewAccountPromotion(string $code, User $user): bool
    {
        $promotion = $this->getEnabledAndValidPromotion(
            $code,
            Promotion::TYPE_NEW_ACCOUNT
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

        if ((Promotion::TYPE_SYSTEM === $promotion->getType()) ||
            ((in_array($promotion->getType(), [Promotion::TYPE_EXISTING_ACCOUNT, Promotion::TYPE_NEW_ACCOUNT])) &&
            (false === $user->hasPromotion($promotion)))
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

    public function applySystemPromotion(string $code, User $user): bool
    {
        $promotion = $this->getEnabledAndValidPromotion(
            $code,
            Promotion::TYPE_SYSTEM
        );

        $result = false;

        if (null !== $promotion) {
            $result = $this->applyPromotion($promotion, $user);
        }

        return $result;
    }
}
