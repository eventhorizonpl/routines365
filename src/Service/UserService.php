<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;

class UserService
{
    private PaginatorInterface $paginator;
    private UserManager $userManager;
    private UserPasswordEncoderInterface $passwordEncoder;
    private UserRepository $userRepository;

    public function __construct(
        PaginatorInterface $paginator,
        UserManager $userManager,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository
    ) {
        $this->paginator = $paginator;
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

    public function createMissingUserAccountRelation(): UserService
    {
        $page = 1;
        $limit = 5;

        $usersQuery = $this->userRepository->findForCreateMissingUserAccountRelation();

        do {
            $users = $this->paginator->paginate($usersQuery, $page, $limit);

            foreach ($users as $user) {
                $user->setAccount($user->getOldAccount());
                $this->userManager->save($user);
            }
            ++$page;
        } while ($users->getCurrentPageNumber() <= $users->getPageCount());

        return $this;
    }

    public function onAuthenticationSuccess(User $user): User
    {
        $user
            ->setApiToken((string) Uuid::v4())
            ->setLastLoginAt(new DateTimeImmutable());
        $this->userManager->save($user);

        return $user;
    }
}
