<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Project;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\{GoalManager, ProjectManager};
use App\Repository\ProjectRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 * @coversNothing
 */
final class ProjectManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?GoalManager $goalManager;
    /**
     * @inject
     */
    private ?ProjectManager $projectManager;
    /**
     * @inject
     */
    private ?ProjectRepository $projectRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        $this->goalManager = null;
        $this->projectManager = null;
        $this->projectRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function createProject(): Project
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getProjects()->first();
    }

    public function testConstruct(): void
    {
        $projectManager = new ProjectManager($this->entityManager, $this->goalManager, $this->validator);

        $this->assertInstanceOf(ProjectManager::class, $projectManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $project = $this->createProject();
        $user = $project->getUser();
        $name = 'test name';
        $project->setName($name);
        $projectId = $project->getId();
        $projects = [];
        $projects[] = $project;

        $projectManager = $this->projectManager->bulkSave($projects, (string) $user, 1);
        $this->assertInstanceOf(ProjectManager::class, $projectManager);

        $project2 = $this->projectRepository->findOneById($projectId);
        $this->assertInstanceOf(Project::class, $project2);
        $this->assertSame($name, $project2->getName());
    }

    public function testDelete(): void
    {
        $this->purge();
        $project = $this->createProject();
        $projectId = $project->getId();

        $projectManager = $this->projectManager->delete($project);
        $this->assertInstanceOf(ProjectManager::class, $projectManager);

        $project2 = $this->projectRepository->findOneById($projectId);
        $this->assertNull($project2);
    }

    public function testSave(): void
    {
        $this->purge();
        $project = $this->createProject();
        $user = $project->getUser();

        $projectManager = $this->projectManager->save($project, (string) $user, true);
        $this->assertInstanceOf(ProjectManager::class, $projectManager);

        $project->setIsCompleted(false);
        $project->setCompletedAt(new DateTimeImmutable());
        $projectManager = $this->projectManager->save($project);
        $this->assertInstanceOf(ProjectManager::class, $projectManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $project = $this->createProject();
        $user = $project->getUser();
        $project->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $projectManager = $this->projectManager->save($project, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $project = $this->createProject();
        $user = $project->getUser();
        $goal = $user->getGoals()->first();
        $project->addGoal($goal);
        $projectId = $project->getId();

        $projectManager = $this->projectManager->softDelete($project, (string) $user);
        $this->assertInstanceOf(ProjectManager::class, $projectManager);

        $project2 = $this->projectRepository->findOneById($projectId);
        $this->assertInstanceOf(Project::class, $project2);
        $this->assertTrue(null !== $project2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $project = $this->createProject();
        $user = $project->getUser();
        $projectId = $project->getId();

        $projectManager = $this->projectManager->softDelete($project, (string) $user);
        $this->assertInstanceOf(ProjectManager::class, $projectManager);

        $project2 = $this->projectRepository->findOneById($projectId);
        $this->assertInstanceOf(Project::class, $project2);
        $this->assertTrue(null !== $project2->getDeletedAt());

        $projectManager = $this->projectManager->undelete($project);
        $this->assertInstanceOf(ProjectManager::class, $projectManager);

        $project3 = $this->projectRepository->findOneById($projectId);
        $this->assertInstanceOf(Project::class, $project3);
        $this->assertTrue(null === $project3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $project = $this->createProject();

        $errors = $this->projectManager->validate($project);
        $this->assertCount(0, $errors);

        $project->setName('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->projectManager->validate($project);
        $this->assertCount(1, $errors);
    }
}
