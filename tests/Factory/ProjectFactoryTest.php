<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Project;
use App\Factory\ProjectFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

class ProjectFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $projectFactory = new ProjectFactory();

        $this->assertInstanceOf(ProjectFactory::class, $projectFactory);
    }

    public function testCreateProject()
    {
        $projectFactory = new ProjectFactory();
        $project = $projectFactory->createProject();
        $this->assertInstanceOf(Project::class, $project);
    }

    public function testCreateProjectWithRequired()
    {
        $isCompleted = $this->faker->boolean;
        $name = $this->faker->sentence;
        $projectFactory = new ProjectFactory();
        $project = $projectFactory->createProjectWithRequired(
            $isCompleted,
            $name
        );
        $this->assertInstanceOf(Project::class, $project);
        $this->assertEquals($isCompleted, $project->getIsCompleted());
        $this->assertEquals($name, $project->getName());
    }
}
