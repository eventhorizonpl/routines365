<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Project;
use App\Factory\ProjectFactory;
use Faker\Factory;
use Faker\Generator;

class ProjectFaker
{
    private Generator $faker;

    public function __construct(
        private ProjectFactory $projectFactory
    ) {
        $this->faker = Factory::create();
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
            $name = (string) $this->faker->text(64);
        }

        $project = $this->projectFactory->createProjectWithRequired(
            $isCompleted,
            $name
        );

        $project->setDescription($description);

        return $project;
    }
}
