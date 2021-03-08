<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Account;
use App\Entity\User;
use Symfony\Component\Uid\Uuid;

class UserFactory
{
    public function __construct(
        private AccountFactory $accountFactory,
        private ProfileFactory $profileFactory,
        private UserKytFactory $userKytFactory
    ) {
    }

    public function createUser(?Account $account = null): User
    {
        $user = new User();
        $user->setReferrerCode((string) Uuid::v4())
            ->setUuid((string) Uuid::v4());
        if (null === $account) {
            $account = $this->accountFactory->createAccount();
        }
        $account->addUser($user);
        $profile = $this->profileFactory->createProfile();
        $profile->setUser($user);
        $userKyt = $this->userKytFactory->createUserKyt();
        $userKyt->setUser($user);
        $user->setAccount($account)
            ->setProfile($profile)
            ->setUserKyt($userKyt);

        return $user;
    }

    public function createUserLead(): User
    {
        $user = $this->createUser();

        $user
            ->setIsEnabled(true)
            ->setIsVerified(true)
            ->setType(User::TYPE_LEAD);

        return $user;
    }

    public function createUserWithRequired(
        string $email,
        bool $isEnabled,
        array $roles,
        string $type
    ): User {
        $user = $this->createUser();

        $user
            ->setEmail($email)
            ->setIsEnabled($isEnabled)
            ->setRoles($roles)
            ->setType($type);

        return $user;
    }
}
