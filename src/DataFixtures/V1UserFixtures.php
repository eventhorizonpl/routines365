<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Faker\UserFaker;
use App\Manager\UserManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class V1UserFixtures extends Fixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public const REGULAR_USER_LIMIT = 50;
    public const REGULAR_USER_REFERENCE = 'regular-user-reference';

    private UserFaker $userFaker;
    private UserManager $userManager;

    public function __construct(
        UserFaker $userFaker,
        UserManager $userManager
    ) {
        $this->userFaker = $userFaker;
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userFaker->createUser(
            'admin@admin.com',
            true,
            'admin',
            [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN, User::ROLE_USER],
            User::TYPE_STAFF
        );
        $user->getProfile()
            ->setSendWeeklyMonthlyStatistics(false)
            ->setTimezone('Europe/Warsaw');

        $this->userManager->save($user);

        $kernel = $this->container->get('kernel');
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            $users = [];
            $referrerUser = null;
            for ($userId = 1; $userId <= self::REGULAR_USER_LIMIT; ++$userId) {
                $user = $this->userFaker->createUser(
                    'test'.(string) $userId.'@test.com',
                    true,
                    'test'.(string) $userId,
                    [User::ROLE_USER],
                    User::TYPE_PROSPECT
                );
                $user->getProfile()->setFirstName('test'.(string) $userId)
                    ->setLastName('test'.(string) $userId)
                    ->setSendWeeklyMonthlyStatistics(false)
                    ->setShowMotivationalMessages(true)
                    ->setTimezone('Europe/Warsaw');
                if (null !== $referrerUser) {
                    $user->setReferrer($referrerUser);
                }
                $users[] = $user;
                $this->addReference(self::REGULAR_USER_REFERENCE.'_'.(string) $userId, $user);
                $referrerUser = $user;
            }
            $this->userManager->bulkSave($users);
        }
    }
}
