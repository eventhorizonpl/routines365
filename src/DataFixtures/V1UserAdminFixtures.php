<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Manager\UserManager;
use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class V1UserAdminFixtures extends Fixture implements ContainerAwareInterface, FixtureGroupInterface
{
    use ContainerAwareTrait;

    public const ADMIN_USER_REFERENCE = 'admin-user';

    public function __construct(
        private UserFactory $userFactory,
        private UserManager $userManager,
        private UserService $userService
    ) {
    }

    public static function getGroups(): array
    {
        return ['v1deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFactory->createUserWithRequired(
            'michal@eventhorizonlabs.eu',
            true,
            [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN, User::ROLE_USER],
            User::TYPE_STAFF
        );
        $user = $this->userService->encodePassword($user, 'michal');
        $user->getProfile()->setSendWeeklyMonthlyStatistics(false)
            ->setTimezone('Europe/Warsaw');

        $this->userManager->save($user);

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);

        $user = $this->userFactory->createUserWithRequired(
            'mkpiotrowskiprivate@gmail.com',
            true,
            [User::ROLE_USER],
            User::TYPE_PROSPECT
        );
        $user = $this->userService->encodePassword($user, 'michal');
        $user->getProfile()->setFirstName('Michal')
            ->setLastName('Piotrowski')
            ->setSendWeeklyMonthlyStatistics(false)
            ->setShowMotivationalMessages(true)
            ->setTimezone('Europe/Warsaw');

        $this->userManager->save($user);

        $user = $this->userFactory->createUserWithRequired(
            'epiotrowska16@gmail.com',
            true,
            [User::ROLE_USER],
            User::TYPE_PROSPECT
        );
        $user = $this->userService->encodePassword($user, 'ewelina');
        $user->getProfile()->setFirstName('Ewelina')
            ->setLastName('Piotrowska')
            ->setSendWeeklyMonthlyStatistics(false)
            ->setShowMotivationalMessages(true)
            ->setTimezone('Europe/Warsaw');

        $this->userManager->save($user);
    }
}
