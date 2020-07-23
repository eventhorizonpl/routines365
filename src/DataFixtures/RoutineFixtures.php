<?php

namespace App\DataFixtures;

use App\Faker\RoutineFaker;
use App\Manager\RoutineManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class RoutineFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const ROUTINE_LIMIT = 10;
    public const ROUTINE_REFERENCE = 'routine_reference';

    private RoutineFaker $routineFaker;
    private RoutineManager $routineManager;

    public function __construct(
        RoutineFaker $routineFaker,
        RoutineManager $routineManager
    ) {
        $this->routineFaker = $routineFaker;
        $this->routineManager = $routineManager;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $kernel = $this->container->get('kernel');
        $routines = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 10; $userId <= UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($routineId = 1; $routineId <= self::ROUTINE_LIMIT; ++$routineId) {
                    $routine = $this->routineFaker->createRoutine();
                    $routine->setUser($this->getReference(UserFixtures::REGULAR_USER_REFERENCE.'_'.(string) $userId));
                    $routines[] = $routine;
                    $this->addReference(self::ROUTINE_REFERENCE.'-'.(string) $userId.'-'.(string) $routineId, $routine);
                }
            }
        }

        $this->routineManager->bulkSave($routines);
    }
}
