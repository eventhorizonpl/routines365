<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Project;
use Symfony\Component\Uid\Uuid;

class ProjectFactory
{
    public function createProject(): Project
    {
        $project = new Project();
        $project->setUuid(Uuid::v4());

        return $project;
    }

    public function createProjectWithRequired(
        bool $isCompleted,
        string $name
    ): Project {
        $project = $this->createProject();

        $project
            ->setIsCompleted($isCompleted)
            ->setName($name);

        return $project;
    }
}
