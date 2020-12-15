<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Promotion;
use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\PromotionRepository;

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

    public function applyExistingAccountPromotion(string $code, User $user): bool
    {
        $promotion = $this->promotionRepository->findOneByCodeAndType(
            $code,
            Promotion::TYPE_EXISTING_ACCOUNT
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

        if (false === $user->hasPromotion($promotion)) {
            $user->addPromotion($promotion);
            $this->accountOperationService->deposit(
                $user->getAccount(),
                'Deposit for promotion '.$promotion->getCode().' '.$promotion->getName(),
                $promotion->getEmailNotifications(),
                $promotion->getSmsNotifications()
            );
            $saveUser = true;
        }

        if (true === $saveUser) {
            $this->userManager->save($user);
        }

        return $saveUser;
    }
}
