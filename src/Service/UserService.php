<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Enum\UserTypeEnum;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use DateTime;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    public function __construct(
        private PaginatorInterface $paginator,
        private PromotionService $promotionService,
        private UserManager $userManager,
        private UserPasswordEncoderInterface $passwordEncoder,
        private UserRepository $userRepository
    ) {
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
        $user->setType(UserTypeEnum::CUSTOMER);
        $this->userManager->save($user);

        return $user;
    }

    public function changeTypeToProspect(User $user): User
    {
        $user->setType(UserTypeEnum::PROSPECT);
        $this->userManager->save($user);

        return $user;
    }

    public function onAuthenticationSuccess(User $user): User
    {
        $user
            ->setLastLoginAt(new DateTimeImmutable())
        ;
        $this->userManager->save($user);

        return $user;
    }

    public function rewardUserActivity(): self
    {
        $page = 1;
        $limit = 5;

        $lastActivityAt = new DateTime();
        $lastActivityAt->modify('-1 day');
        $lastActivityAt = DateTimeImmutable::createFromMutable($lastActivityAt);
        $usersQuery = $this->userRepository->findForRewardUserActivity($lastActivityAt);

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
