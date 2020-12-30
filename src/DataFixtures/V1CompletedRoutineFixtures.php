<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\CompletedRoutineFaker;
use App\Manager\CompletedRoutineManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class V1CompletedRoutineFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const COMPLETED_ROUTINE_LIMIT = 5;
    public const COMPLETED_ROUTINE_REFERENCE = 'completed_routine_reference';

    private CompletedRoutineFaker $completedRoutineFaker;
    private CompletedRoutineManager $completedRoutineManager;

    public function __construct(
        CompletedRoutineFaker $completedRoutineFaker,
        CompletedRoutineManager $completedRoutineManager
    ) {
        $this->completedRoutineFaker = $completedRoutineFaker;
        $this->completedRoutineManager = $completedRoutineManager;
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
        $completedRoutines = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 1; $userId <= V1UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= V1RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                    for ($completedRoutineId = 1; $completedRoutineId <= self::COMPLETED_ROUTINE_LIMIT; ++$completedRoutineId) {
                        $completedRoutine = $this->completedRoutineFaker->createCompletedRoutine();
                        $completedRoutine->setRoutine($this->getReference(V1RoutineFixtures::ROUTINE_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId));
                        $completedRoutine->setUser($this->getReference(V1UserFixtures::REGULAR_USER_REFERENCE.'_'.(string) $userId));
                        $completedRoutines[] = $completedRoutine;
                        $this->addReference(self::COMPLETED_ROUTINE_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId.'-'.(string) $completedRoutineId, $completedRoutine);
                    }
                }
            }
        }

        $this->completedRoutineManager->bulkSave($completedRoutines);
    }
}
