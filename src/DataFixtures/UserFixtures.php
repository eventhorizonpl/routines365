<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Manager\UserManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    private UserFactory $userFactory;
    private UserManager $userManager;

    public function __construct(
        UserFactory $userFactory,
        UserManager $userManager
    ) {
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

        $this->userManager->save($user);

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
    }
}
