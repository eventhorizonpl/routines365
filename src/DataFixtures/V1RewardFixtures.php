<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\RewardFaker;
use App\Manager\RewardManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class V1RewardFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const REWARD_LIMIT = 5;
    public const REWARD_REFERENCE = 'reward_reference';

    public function __construct(
        private RewardFaker $rewardFaker,
        private RewardManager $rewardManager
    ) {
    }

    public function getDependencies(): array
    {
        return [
            V1RoutineFixtures::class,
            V1UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');
        $rewards = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 1; $userId <= V1UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= V1RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                    for ($rewardId = 1; $rewardId <= self::REWARD_LIMIT; ++$rewardId) {
                        $reward = $this->rewardFaker->createReward();
                        $reward->setRoutine($this->getReference(sprintf(
                            '%s-%d-%d',
                            V1RoutineFixtures::ROUTINE_REFERENCE,
                            $userId,
                            $routineId
                        )));
                        $reward->setUser($this->getReference(sprintf(
                            '%s-%d',
                            V1UserFixtures::REGULAR_USER_REFERENCE,
                            $userId
                        )));
                        $rewards[] = $reward;
                        $this->addReference(sprintf(
                            '%s-%d-%d-%d',
                            self::REWARD_REFERENCE,
                            $userId,
                            $routineId,
                            $rewardId
                        ), $reward);
                    }
                }
            }
        }

        $this->rewardManager->bulkSave($rewards);
    }
}
