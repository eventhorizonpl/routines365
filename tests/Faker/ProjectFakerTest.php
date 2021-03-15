<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Project;
use App\Factory\ProjectFactory;
use App\Faker\ProjectFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ProjectFakerTest extends AbstractDoctrineTestCase
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
        $this->projectFactory = null;
        $this->projectFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $projectFaker = new ProjectFaker($this->projectFactory);

        $this->assertInstanceOf(ProjectFaker::class, $projectFaker);
    }

    public function testCreateProject(): void
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
        $this->assertSame($description, $project->getDescription());
        $this->assertSame($isCompleted, $project->getIsCompleted());
        $this->assertSame($name, $project->getName());
    }
}
