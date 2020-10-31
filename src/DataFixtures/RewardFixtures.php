<?php

namespace App\DataFixtures;

use App\Faker\RewardFaker;
use App\Manager\RewardManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class RewardFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const REWARD_LIMIT = 5;
    public const REWARD_REFERENCE = 'reward_reference';

    private RewardFaker $rewardFaker;
    private RewardManager $rewardManager;

    public function __construct(
        RewardFaker $rewardFaker,
        RewardManager $rewardManager
    ) {
        $this->rewardFaker = $rewardFaker;
        $this->rewardManager = $rewardManager;
    }

    public function getDependencies(): array
    {
        return [
            RoutineFixtures::class,
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');
        $rewards = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 1; $userId <= UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                    for ($rewardId = 1; $rewardId <= self::REWARD_LIMIT; ++$rewardId) {
                        $reward = $this->rewardFaker->createReward();
                        $reward->setRoutine($this->getReference(RoutineFixtures::ROUTINE_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId));
                        $reward->setUser($this->getReference(UserFixtures::REGULAR_USER_REFERENCE.'_'.(string) $userId));
                        $rewards[] = $reward;
                        $this->addReference(self::REWARD_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId.'-'.(string) $rewardId, $reward);
                    }
                }
            }
        }

        $this->rewardManager->bulkSave($rewards);
    }
}
