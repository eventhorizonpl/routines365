<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Project;
use App\Factory\ProjectFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

/**
 * @internal
 * @coversNothing
 */
final class ProjectFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        $this->faker = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $projectFactory = new ProjectFactory();

        $this->assertInstanceOf(ProjectFactory::class, $projectFactory);
    }

    public function testCreateProject(): void
    {
        $projectFactory = new ProjectFactory();
        $project = $projectFactory->createProject();
        $this->assertInstanceOf(Project::class, $project);
    }

    public function testCreateProjectWithRequired(): void
    {
        $isCompleted = $this->faker->boolean();
        $name = $this->faker->sentence();
        $projectFactory = new ProjectFactory();
        $project = $projectFactory->createProjectWithRequired(
            $isCompleted,
            $name
        );
        $this->assertInstanceOf(Project::class, $project);
        $this->assertSame($isCompleted, $project->getIsCompleted());
        $this->assertSame($name, $project->getName());
    }
}
