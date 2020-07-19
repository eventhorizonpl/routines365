<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Manager\UserManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use libphonenumber\PhoneNumberUtil;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    private PhoneNumberUtil $phoneNumberUtil;
    private UserFactory $userFactory;
    private UserManager $userManager;

    public function __construct(
        UserFactory $userFactory,
        UserManager $userManager
    ) {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFactory->createUserWithRequired(
            'admin@admin.com',
            true,
            'admin',
            ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN', 'ROLE_USER']
        );
        $phone = $this->phoneNumberUtil->parse('+48881573056');
        $user->getProfile()->setPhone($phone);

        $this->userManager->save($user);

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
    }
}
