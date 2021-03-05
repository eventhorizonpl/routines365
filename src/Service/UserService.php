<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;

class UserService
{
    private PaginatorInterface $paginator;
    private PromotionService $promotionService;
    private UserManager $userManager;
    private UserPasswordEncoderInterface $passwordEncoder;
    private UserRepository $userRepository;

    public function __construct(
        PaginatorInterface $paginator,
        PromotionService $promotionService,
        UserManager $userManager,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository
    ) {
        $this->paginator = $paginator;
        $this->promotionService = $promotionService;
        $this->userManager = $userManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
    }

    public function encodePassword(
        User $user,
        string $password
    ): User {
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));

        return $user;
    }

    public function changeTypeToCustomer(User $user): User
    {
        $user->setType(User::TYPE_CUSTOMER);
        $this->userManager->save($user);

        return $user;
    }

    public function changeTypeToProspect(User $user): User
    {
        $user->setType(User::TYPE_PROSPECT);
        $this->userManager->save($user);

        return $user;
    }

    public function onAuthenticationSuccess(User $user): User
    {
        $user
            ->setApiToken((string) Uuid::v4())
            ->setLastLoginAt(new DateTimeImmutable());
        $this->userManager->save($user);

        return $user;
    }

    public function rewardUserActivity(): UserService
    {
        $page = 1;
        $limit = 5;

        $lastLoginAt = new DateTime();
        $lastLoginAt->modify('-1 day');
        $lastLoginAt = DateTimeImmutable::createFromMutable($lastLoginAt);
        $usersQuery = $this->userRepository->findForRewardUserActivity($lastLoginAt);

        do {
            $users = $this->paginator->paginate($usersQuery, $page, $limit);
            foreach ($users as $user) {
                $this->promotionService->applySystemPromotion('ACTIVE5', $user);
            }
            ++$page;
        } while ($users->getCurrentPageNumber() <= $users->getPageCount());

        return $this;
    }
}
