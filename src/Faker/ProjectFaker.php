<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Project;
use App\Factory\ProjectFactory;
use App\Manager\ProjectManager;
use Faker\Factory;
use Faker\Generator;

class ProjectFaker
{
    private Generator $faker;
    private ProjectFactory $projectFactory;
    private ProjectManager $projectManager;

    public function __construct(
        ProjectFactory $projectFactory,
        ProjectManager $projectManager
    ) {
        $this->faker = Factory::create();
        $this->projectFactory = $projectFactory;
        $this->projectManager = $projectManager;
    }

    public function createProject(
        ?string $description = null,
        ?bool $isCompleted = null,
        ?string $name = null
    ): Project {
        if (null === $description) {
            $description = (string) $this->faker->text;
        }

        if (null === $isCompleted) {
            $isCompleted = (bool) $this->faker->boolean;
        }

        if (null === $name) {
            $name = (string) $this->faker->word;
        }

        $project = $this->projectFactory->createProjectWithRequired(
            $isCompleted,
            $name
        );

        $project->setDescription($description);

        return $project;
    }

    public function createProjectPersisted(
        ?string $description = null,
        ?bool $isCompleted = null,
        ?string $name = null
    ): Project {
        $project = $this->createProject(
            $description,
            $isCompleted,
            $name
        );
        $this->projectManager->save($project);

        return $project;
    }
}
