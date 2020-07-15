<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Manager\UserManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

class UserFixtures extends Fixture
{
    private UserFactory $userFactory;
    private UserManager $userManager;

    public function __construct(
        UserFactory $userFactory,
        UserManager $userManager
    ) {
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager)
    {
        $user = $this->userFactory->createUserWithRequired(
            'admin@admin.com',
            true,
            'admin',
            ['ROLE_ADMIN', 'ROLE_USER']
        );

        $this->userManager->save($user, Uuid::v4());
    }
}
