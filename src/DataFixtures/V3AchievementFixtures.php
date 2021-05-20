<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\{Achievement, User};
use App\Enum\{AchievementTypeEnum, UserTypeEnum};
use App\Factory\AchievementFactory;
use App\Manager\AchievementManager;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\{Fixture, FixtureGroupInterface};
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class V3AchievementFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function __construct(
        private AchievementFactory $achievementFactory,
        private AchievementManager $achievementManager,
        private UserRepository $userRepository
    ) {
    }

    public function getDependencies(): array
    {
        return [
            V1UserAdminFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['v3deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $dataset = [
            [
                'level' => 1,
                'name' => 'Routines student',
                'requirement' => 10,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 2,
                'name' => 'Routines student',
                'requirement' => 33,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 3,
                'name' => 'Routines student',
                'requirement' => 66,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 4,
                'name' => 'Routines follower',
                'requirement' => 100,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 5,
                'name' => 'Routines follower',
                'requirement' => 166,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 6,
                'name' => 'Routines follower',
                'requirement' => 333,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 7,
                'name' => 'Routines professional',
                'requirement' => 500,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 8,
                'name' => 'Routines professional',
                'requirement' => 667,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 9,
                'name' => 'Routines professional',
                'requirement' => 833,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 10,
                'name' => 'Routines master',
                'requirement' => 1000,
                'type' => AchievementTypeEnum::COMPLETED_ROUTINE,
            ],
            [
                'level' => 1,
                'name' => 'Goals student',
                'requirement' => 10,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 2,
                'name' => 'Goals student',
                'requirement' => 33,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 3,
                'name' => 'Goals student',
                'requirement' => 66,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 4,
                'name' => 'Goals follower',
                'requirement' => 100,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 5,
                'name' => 'Goals follower',
                'requirement' => 166,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 6,
                'name' => 'Goals follower',
                'requirement' => 333,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 7,
                'name' => 'Goals professional',
                'requirement' => 500,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 8,
                'name' => 'Goals professional',
                'requirement' => 667,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 9,
                'name' => 'Goals professional',
                'requirement' => 833,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 10,
                'name' => 'Goals master',
                'requirement' => 1000,
                'type' => AchievementTypeEnum::COMPLETED_GOAL,
            ],
            [
                'level' => 1,
                'name' => 'Projects student',
                'requirement' => 1,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 2,
                'name' => 'Projects student',
                'requirement' => 3,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 3,
                'name' => 'Projects student',
                'requirement' => 6,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 4,
                'name' => 'Projects follower',
                'requirement' => 10,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 5,
                'name' => 'Projects follower',
                'requirement' => 16,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 6,
                'name' => 'Projects follower',
                'requirement' => 33,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 7,
                'name' => 'Projects professional',
                'requirement' => 50,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 8,
                'name' => 'Projects professional',
                'requirement' => 66,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 9,
                'name' => 'Projects professional',
                'requirement' => 83,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 10,
                'name' => 'Projects master',
                'requirement' => 100,
                'type' => AchievementTypeEnum::COMPLETED_PROJECT,
            ],
            [
                'level' => 1,
                'name' => 'Scribe student',
                'requirement' => 10,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
            [
                'level' => 2,
                'name' => 'Scribe student',
                'requirement' => 33,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
            [
                'level' => 3,
                'name' => 'Scribe student',
                'requirement' => 66,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
            [
                'level' => 4,
                'name' => 'Scribe follower',
                'requirement' => 100,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
            [
                'level' => 5,
                'name' => 'Scribe follower',
                'requirement' => 166,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
            [
                'level' => 6,
                'name' => 'Scribe follower',
                'requirement' => 333,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
            [
                'level' => 7,
                'name' => 'Scribe professional',
                'requirement' => 500,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
            [
                'level' => 8,
                'name' => 'Scribe professional',
                'requirement' => 667,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
            [
                'level' => 9,
                'name' => 'Scribe professional',
                'requirement' => 833,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
            [
                'level' => 10,
                'name' => 'Scribe master',
                'requirement' => 1000,
                'type' => AchievementTypeEnum::CREATED_NOTE,
            ],
        ];

        $achievements = [];
        foreach ($dataset as $data) {
            $achievements[] = $this->achievementFactory->createAchievementWithRequired(
                true,
                $data['level'],
                $data['name'],
                $data['requirement'],
                $data['type']
            );
        }

        $user = $this->userRepository->findOneBy([
            'type' => UserTypeEnum::STAFF,
        ], [
            'id' => 'ASC',
        ]);

        if (null !== $user) {
            $this->achievementManager->bulkSave($achievements, (string) $user);
        }
    }
}
