<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Faker\{TestimonialFaker, UserFaker};
use App\Manager\UserManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\{ContainerAwareInterface, ContainerAwareTrait};

class V1UserFixtures extends Fixture implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public const REGULAR_USER_LIMIT = 50;
    public const REGULAR_USER_REFERENCE = 'regular-user-reference';

    public function __construct(
        private TestimonialFaker $testimonialFaker,
        private UserFaker $userFaker,
        private UserManager $userManager
    ) {
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
            ->setTimezone('Europe/Warsaw')
        ;

        $this->userManager->save($user);

        $kernel = $this->container->get('kernel');
        if (\in_array($kernel->getEnvironment(), ['dev', 'test'], true)) {
            $users = [];
            $referrerUser = null;
            for ($userId = 1; $userId <= self::REGULAR_USER_LIMIT; ++$userId) {
                $user = $this->userFaker->createUser(
                    sprintf('test%d@example.org', $userId),
                    true,
                    sprintf('test%d', $userId),
                    [User::ROLE_USER],
                    User::TYPE_PROSPECT
                );
                $testimonial = $this->testimonialFaker->createTestimonial();
                $testimonial->setUser($user);
                $user
                    ->setTestimonial($testimonial)
                    ->getProfile()
                    ->setFirstName(sprintf('test%d', $userId))
                    ->setLastName(sprintf('test%d', $userId))
                    ->setSendWeeklyMonthlyStatistics(false)
                    ->setShowMotivationalMessages(true)
                    ->setTimezone('Europe/Warsaw')
                ;
                if (null !== $referrerUser) {
                    $user->setReferrer($referrerUser);
                }
                $users[] = $user;
                $this->addReference(sprintf(
                    '%s-%d',
                    self::REGULAR_USER_REFERENCE,
                    $userId
                ), $user);
                $referrerUser = $user;
            }
            $this->userManager->bulkSave($users);
        }
    }
}
