<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\{Promotion, User};
use App\Enum\{PromotionTypeEnum, UserTypeEnum};
use App\Factory\PromotionFactory;
use App\Manager\PromotionManager;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\{Fixture, FixtureGroupInterface};
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class V4PromotionFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function __construct(
        private PromotionFactory $promotionFactory,
        private PromotionManager $promotionManager,
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
        return ['v4deployment'];
    }

    public function load(ObjectManager $manager): void
    {
        $dataset = [
            [
                'code' => 'REWARD10',
                'name' => '+10 notifications reward promotion',
                'notifications' => 10,
                'sms_notifications' => 0,
                'type' => PromotionTypeEnum::SYSTEM,
            ],
        ];

        $promotions = [];
        foreach ($dataset as $data) {
            $promotions[] = $this->promotionFactory->createPromotionWithRequired(
                $data['code'],
                true,
                $data['name'],
                $data['notifications'],
                $data['sms_notifications'],
                $data['type']
            );
        }

        $user = $this->userRepository->findOneBy([
            'type' => UserTypeEnum::STAFF,
        ], [
            'id' => 'ASC',
        ]);

        if (null !== $user) {
            $this->promotionManager->bulkSave($promotions, (string) $user);
        }
    }
}
