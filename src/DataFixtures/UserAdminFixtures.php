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
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class UserAdminFixtures extends Fixture implements ContainerAwareInterface, FixtureGroupInterface
{
    use ContainerAwareTrait;

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
        $user->getProfile()->setTimezone('Europe/Warsaw');

        $this->userManager->save($user);

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);

        $user = $this->userFactory->createUserWithRequired(
            'mkpiotrowskiprivate@gmail.com',
            true,
            [User::ROLE_USER],
            User::TYPE_PROSPECT
        );
        $user = $this->userService->encodePassword($user, 'michal');
        $phone = $this->phoneNumberUtil->parse('+48881573056');
        $user->getProfile()->setFirstName('Michal');
        $user->getProfile()->setLastName('Piotrowski');
        $user->getProfile()->setShowMotivationalMessages(true);
        $user->getProfile()->setPhone($phone);
        $user->getProfile()->setTimezone('Europe/Warsaw');

        $this->userManager->save($user);

        $user = $this->userFactory->createUserWithRequired(
            'epiotrowska16@gmail.com',
            true,
            [User::ROLE_USER],
            User::TYPE_PROSPECT
        );
        $user = $this->userService->encodePassword($user, 'ewelina');
        $phone = $this->phoneNumberUtil->parse('+48530573056');
        $user->getProfile()->setFirstName('Ewelina');
        $user->getProfile()->setLastName('Piotrowska');
        $user->getProfile()->setShowMotivationalMessages(true);
        $user->getProfile()->setPhone($phone);
        $user->getProfile()->setTimezone('Europe/Warsaw');

        $this->userManager->save($user);
    }
}
