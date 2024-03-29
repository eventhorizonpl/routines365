<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\CompletedRoutineFaker;
use App\Manager\CompletedRoutineManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\{ContainerAwareInterface, ContainerAwareTrait};

class V1CompletedRoutineFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const COMPLETED_ROUTINE_LIMIT = 5;
    public const COMPLETED_ROUTINE_REFERENCE = 'completed_routine_reference';

    public function __construct(
        private CompletedRoutineFaker $completedRoutineFaker,
        private CompletedRoutineManager $completedRoutineManager
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
        $completedRoutines = [];
        if (\in_array($kernel->getEnvironment(), ['dev', 'test'], true)) {
            for ($userId = 1; $userId <= V1UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= V1RoutineFixtures::ROUTINE_LIMIT; ++$routineId) {
                    for ($completedRoutineId = 1; $completedRoutineId <= self::COMPLETED_ROUTINE_LIMIT; ++$completedRoutineId) {
                        $completedRoutine = $this->completedRoutineFaker->createCompletedRoutine();
                        $completedRoutine->setRoutine($this->getReference(sprintf(
                            '%s-%d-%d',
                            V1RoutineFixtures::ROUTINE_REFERENCE,
                            $userId,
                            $routineId
                        )));
                        $completedRoutine->setUser($this->getReference(sprintf(
                            '%s-%d',
                            V1UserFixtures::REGULAR_USER_REFERENCE,
                            $userId
                        )));
                        $completedRoutines[] = $completedRoutine;
                        $this->addReference(sprintf(
                            '%s-%d-%d-%d',
                            self::COMPLETED_ROUTINE_REFERENCE,
                            $userId,
                            $routineId,
                            $completedRoutineId
                        ), $completedRoutine);
                    }
                }
            }
        }

        $this->completedRoutineManager->bulkSave($completedRoutines);
    }
}
