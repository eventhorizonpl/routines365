<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;

class UserFactory
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createUser(): User
    {
        $user = new User();
        $user->setUuid(Uuid::v4());

        return $user;
    }

    public function createUserWithRequired(
        string $email,
        bool $isEnabled,
        string $password,
        array $roles
    ): User {
        $user = $this->createUser();

        $user->setEmail($email);
        $user->setIsEnabled($isEnabled);
        $user->setRoles($roles);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));

        return $user;
    }
}
