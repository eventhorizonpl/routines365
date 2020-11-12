<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Manager\UserManager;
use DateTimeImmutable;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private UserManager $userManager;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        UserManager $userManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userManager = $userManager;
        $this->passwordEncoder = $passwordEncoder;
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

    public function updateLastLoginAt(User $user): User
    {
        $user->setLastLoginAt(new DateTimeImmutable());
        $this->userManager->save($user);

        return $user;
    }
}
