<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\RoutineFaker;
use App\Manager\RoutineManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\{ContainerAwareInterface, ContainerAwareTrait};

class V1RoutineFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const ROUTINE_LIMIT = 5;
    public const ROUTINE_REFERENCE = 'routine_reference';

    public function __construct(
        private RoutineFaker $routineFaker,
        private RoutineManager $routineManager
    ) {
    }

    public function getDependencies(): array
    {
        return [
            V1UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');
        $routines = [];
        if (\in_array($kernel->getEnvironment(), ['dev', 'test'], true)) {
            for ($userId = 1; $userId <= V1UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= self::ROUTINE_LIMIT; ++$routineId) {
                    $routine = $this->routineFaker->createRoutine();
                    $routine->setUser($this->getReference(sprintf(
                        '%s-%d',
                        V1UserFixtures::REGULAR_USER_REFERENCE,
                        $userId
                    )));
                    $routines[] = $routine;
                    $this->addReference(sprintf(
                        '%s-%d-%d',
                        self::ROUTINE_REFERENCE,
                        $userId,
                        $routineId
                    ), $routine);
                }
            }
        }

        $this->routineManager->bulkSave($routines);
    }
}
