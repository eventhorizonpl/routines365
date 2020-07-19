<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Manager\UserManager;
use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use libphonenumber\PhoneNumberUtil;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    private PhoneNumberUtil $phoneNumberUtil;
    private UserFactory $userFactory;
    private UserManager $userManager;
    private UserService $userService;

    public function __construct(
        UserFactory $userFactory,
        UserManager $userManager,
        UserService $userService
    ) {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
        $this->userService = $userService;
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFactory->createUserWithRequired(
            'admin@admin.com',
            true,
            [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN, User::ROLE_USER]
        );
        $user = $this->userService->encodePassword($user, 'admin');
        $phone = $this->phoneNumberUtil->parse('+48881573056');
        $user->getProfile()->setPhone($phone);

        $this->userManager->save($user);

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
    }
}
