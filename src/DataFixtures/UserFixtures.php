<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Manager\UserManager;
use App\Service\UserService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class UserFixtures extends Fixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const REGULAR_USER_LIMIT = 99;
    public const REGULAR_USER_REFERENCE = 'regular-user-reference';

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
        $user->getProfile()->setTimezone('Europe/Warsaw');

        $this->userManager->save($user);
        $this->addReference(self::ADMIN_USER_REFERENCE, $user);

        $kernel = $this->container->get('kernel');
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            $users = [];
            for ($userId = 10; $userId <= self::REGULAR_USER_LIMIT; ++$userId) {
                $user = $this->userFactory->createUserWithRequired(
                    'test'.(string) $userId.'@test.com',
                    true,
                    [User::ROLE_USER]
                );
                $user = $this->userService->encodePassword($user, 'test'.(string) $userId);
                $phone = $this->phoneNumberUtil->parse('+488815731'.(string) $userId);
                $user->getProfile()->setPhone($phone);
                $user->getProfile()->setTimezone('Europe/Warsaw');
                $users[] = $user;
                $this->addReference(self::REGULAR_USER_REFERENCE.'_'.(string) $userId, $user);
            }
            $this->userManager->bulkSave($users);
        }
    }
}
