<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Promotion;
use App\Entity\User;
use App\Factory\PromotionFactory;
use App\Manager\PromotionManager;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class V4PromotionFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private PromotionFactory $promotionFactory;
    private PromotionManager $promotionManager;
    private UserRepository $userRepository;

    public function __construct(
        PromotionFactory $promotionFactory,
        PromotionManager $promotionManager,
        UserRepository $userRepository
    ) {
        $this->promotionFactory = $promotionFactory;
        $this->promotionManager = $promotionManager;
        $this->userRepository = $userRepository;
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
                'browser_notifications' => 10,
                'code' => 'REWARD10',
                'email_notifications' => 10,
                'name' => '+10 notifications reward promotion',
                'sms_notifications' => 0,
                'type' => Promotion::TYPE_SYSTEM,
            ],
        ];

        $promotions = [];
        foreach ($dataset as $data) {
            $promotions[] = $this->promotionFactory->createPromotionWithRequired(
                $data['browser_notifications'],
                $data['code'],
                $data['email_notifications'],
                true,
                $data['name'],
                $data['sms_notifications'],
                $data['type']
            );
        }

        $user = $this->userRepository->findOneBy([
            'type' => User::TYPE_STAFF,
        ], [
            'id' => 'ASC',
        ]);

        if (null !== $user) {
            $this->promotionManager->bulkSave($promotions, (string) $user);
        }
    }
}
