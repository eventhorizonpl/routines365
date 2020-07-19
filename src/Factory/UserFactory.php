<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class UserFactory
{
    private ProfileFactory $profileFactory;

    public function __construct(
        ProfileFactory $profileFactory
    ) {
        $this->profileFactory = $profileFactory;
    }

    public function createUser(): User
    {
        $user = new User();
        $user->setUuid(Uuid::v4());
        $profile = $this->profileFactory->createProfile();
        $profile->setUser($user);
        $user->setProfile($profile);

        return $user;
    }

    public function createUserWithRequired(
        string $email,
        bool $isEnabled,
        array $roles
    ): User {
        $user = $this->createUser();

        $user->setEmail($email);
        $user->setIsEnabled($isEnabled);
        $user->setRoles($roles);

        return $user;
    }
}
