<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Project;
use App\Factory\ProjectFactory;
use App\Faker\ProjectFaker;
use App\Tests\AbstractDoctrineTestCase;

class ProjectFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ProjectFactory $projectFactory;
    /**
     * @inject
     */
    private ?ProjectFaker $projectFaker;

    protected function tearDown(): void
    {
        unset($this->projectFactory);
        unset($this->projectFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $projectFaker = new ProjectFaker($this->projectFactory);

        $this->assertInstanceOf(ProjectFaker::class, $projectFaker);
    }

    public function testCreateProject()
    {
        $this->purge();
        $project = $this->projectFaker->createProject();
        $this->assertInstanceOf(Project::class, $project);
        $description = 'test description';
        $isCompleted = false;
        $name = 'test name';
        $project = $this->projectFaker->createProject(
            $description,
            $isCompleted,
            $name
        );
        $this->assertEquals($description, $project->getDescription());
        $this->assertEquals($isCompleted, $project->getIsCompleted());
        $this->assertEquals($name, $project->getName());
    }
}
