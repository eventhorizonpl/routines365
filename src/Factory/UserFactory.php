<?php

namespace App\Factory;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class UserFactory
{
    private AccountFactory $accountFactory;
    private ProfileFactory $profileFactory;

    public function __construct(
        AccountFactory $accountFactory,
        ProfileFactory $profileFactory
    ) {
        $this->accountFactory = $accountFactory;
        $this->profileFactory = $profileFactory;
    }

    public function createUser(): User
    {
        $user = new User();
        $user->setUuid(Uuid::v4());
        $account = $this->accountFactory->createAccount();
        $account->setUser($user);
        $profile = $this->profileFactory->createProfile();
        $profile->setUser($user);
        $user->setAccount($account);
        $user->setProfile($profile);

        return $user;
    }

    public function createUserWithRequired(
        string $email,
        bool $isEnabled,
        array $roles
    ): User {
        $user = $this->createUser();

        $user
            ->setEmail($email)
            ->setIsEnabled($isEnabled)
            ->setRoles($roles);

        return $user;
    }
}
