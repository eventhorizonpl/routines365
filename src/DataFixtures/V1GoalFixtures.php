<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\GoalFaker;
use App\Manager\GoalManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class V1GoalFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const GOAL_LIMIT = 5;
    public const GOAL_REFERENCE = 'goal_reference';

    private GoalFaker $goalFaker;
    private GoalManager $goalManager;

    public function __construct(
        GoalFaker $goalFaker,
        GoalManager $goalManager
    ) {
        $this->goalFaker = $goalFaker;
        $this->goalManager = $goalManager;
    }

    public function getDependencies(): array
    {
        return [
            V2ProjectFixtures::class,
            V1RoutineFixtures::class,
            V1UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');
        $goals = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 1; $userId <= V1UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= V1RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                    for ($goalId = 1; $goalId <= self::GOAL_LIMIT; ++$goalId) {
                        $goal = $this->goalFaker->createGoal();
                        $goal->setRoutine($this->getReference(V1RoutineFixtures::ROUTINE_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId));
                        $goal->setUser($this->getReference(V1UserFixtures::REGULAR_USER_REFERENCE.'_'.(string) $userId));
                        $goals[] = $goal;
                        $this->addReference(self::GOAL_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId.'-'.(string) $goalId, $goal);
                    }
                }
            }
        }

        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 1; $userId <= V1UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($projectId = 1; $projectId <= V2ProjectFixtures::PROJECT_LIMIT; ++$projectId) {
                    for ($routineId = 1; $routineId <= V1RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                        for ($goalId = 1; $goalId <= self::GOAL_LIMIT; ++$goalId) {
                            $goal = $this->goalFaker->createGoal();
                            $goal->setProject($this->getReference(V2ProjectFixtures::PROJECT_REFERENCE.'-'.(string) $userId.'-'.(string) $projectId));
                            $goal->setRoutine($this->getReference(V1RoutineFixtures::ROUTINE_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId));
                            $goal->setUser($this->getReference(V1UserFixtures::REGULAR_USER_REFERENCE.'_'.(string) $userId));
                            $goals[] = $goal;
                            $this->addReference(self::GOAL_REFERENCE.'-'.(string) $userId.'-'.(string) $projectId.'-'.(string) $routineId.'-'.(string) $goalId, $goal);
                        }
                    }
                }
            }
        }

        $this->goalManager->bulkSave($goals);
    }
}
