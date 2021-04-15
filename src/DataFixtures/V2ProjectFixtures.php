<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\ProjectFaker;
use App\Manager\ProjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\{ContainerAwareInterface, ContainerAwareTrait};

class V2ProjectFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const PROJECT_LIMIT = 5;
    public const PROJECT_REFERENCE = 'project_reference';

    public function __construct(
        private ProjectFaker $projectFaker,
        private ProjectManager $projectManager
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
        $projects = [];
        if (\in_array($kernel->getEnvironment(), ['dev', 'test'], true)) {
            for ($userId = 1; $userId <= V1UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($projectId = 1; $projectId <= self::PROJECT_LIMIT; ++$projectId) {
                    $project = $this->projectFaker->createProject();
                    $project->setUser($this->getReference(sprintf(
                        '%s-%d',
                        V1UserFixtures::REGULAR_USER_REFERENCE,
                        $userId
                    )));
                    $projects[] = $project;
                    $this->addReference(sprintf(
                        '%s-%d-%d',
                        self::PROJECT_REFERENCE,
                        $userId,
                        $projectId
                    ), $project);
                }
            }
        }

        $this->projectManager->bulkSave($projects);
    }
}
