<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\UserKyt;
use App\Factory\UserKytFactory;
use App\Manager\UserKytManager;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;

class UserKytService
{
    private PaginatorInterface $paginator;
    private PromotionService $promotionService;
    private UserKytFactory $userKytFactory;
    private UserKytManager $userKytManager;
    private UserRepository $userRepository;

    public function __construct(
        PaginatorInterface $paginator,
        PromotionService $promotionService,
        UserKytFactory $userKytFactory,
        UserKytManager $userKytManager,
        UserRepository $userRepository
    ) {
        $this->paginator = $paginator;
        $this->promotionService = $promotionService;
        $this->userKytFactory = $userKytFactory;
        $this->userKytManager = $userKytManager;
        $this->userRepository = $userRepository;
    }

    public function create(User $user): UserKyt
    {
        $userKyt = $this->userKytFactory->createUserKyt();
        $userKyt->setUser($user);
        $this->userKytManager->save($userKyt, (string) $user);

        return $userKyt;
    }

    public function createMissingUserKyt(): UserKytService
    {
        $page = 1;
        $limit = 5;

        $usersQuery = $this->userRepository->findForCreateMissingUserKyt();

        do {
            $users = $this->paginator->paginate($usersQuery, $page, $limit);

            foreach ($users as $user) {
                if (null === $user->getUserKyt()) {
                    $userKyt = $this->create($user);
                }
            }
            ++$page;
        } while ($users->getCurrentPageNumber() <= $users->getPageCount());

        return $this;
    }

    public function rewardUserKyt(UserKyt $userKyt): bool
    {
        $user = $userKyt->getUser();
        $used = $this->promotionService->applySystemPromotion(
            'REWARD10',
            $user
        );

        $this->userKytManager->save($userKyt, (string) $user);

        return $used;
    }
}
