<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Faker\ProjectFaker;
use App\Manager\ProjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ProjectFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    use ContainerAwareTrait;

    public const PROJECT_LIMIT = 5;
    public const PROJECT_REFERENCE = 'project_reference';

    private ProjectFaker $projectFaker;
    private ProjectManager $projectManager;

    public function __construct(
        ProjectFaker $projectFaker,
        ProjectManager $projectManager
    ) {
        $this->projectFaker = $projectFaker;
        $this->projectManager = $projectManager;
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
        $projects = [];
        if (in_array($kernel->getEnvironment(), ['dev', 'test'])) {
            for ($userId = 1; $userId <= UserFixtures::REGULAR_USER_LIMIT; ++$userId) {
                for ($projectId = 1; $projectId <= self::PROJECT_LIMIT; ++$projectId) {
                    $project = $this->projectFaker->createProject();
                    $project->setUser($this->getReference(UserFixtures::REGULAR_USER_REFERENCE.'_'.(string) $userId));
                    $projects[] = $project;
                    $this->addReference(self::PROJECT_REFERENCE.'-'.(string) $userId.'-'.(string) $projectId, $project);
                }
            }
        }

        $this->projectManager->bulkSave($projects);
    }
}
