<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\ProjectRepository;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

class ProjectRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?ProjectRepository $projectRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        unset($this->managerRegistry);
        unset($this->projectRepository);
        unset($this->userFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $projectRepository = new ProjectRepository($this->managerRegistry);

        $this->assertInstanceOf(ProjectRepository::class, $projectRepository);
    }

    public function testFindByParametersForAdmin()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $projects = $this->projectRepository->findByParametersForAdmin()->getResult();
        $this->assertCount(1, $projects);
        $this->assertIsArray($projects);

        $parameters = [
            'query' => $user->getEmail(),
        ];
        $projects = $this->projectRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $projects);
        $this->assertIsArray($projects);

        $parameters = [
            'query' => 'wrong email',
        ];
        $projects = $this->projectRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $projects);
        $this->assertIsArray($projects);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $projects = $this->projectRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(1, $projects);
        $this->assertIsArray($projects);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $projects = $this->projectRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $projects);
        $this->assertIsArray($projects);
    }

    public function testFindByParametersForFrontend()
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $project = $user->getProjects()->first();

        $projects = $this->projectRepository->findByParametersForFrontend($user);
        $this->assertCount(1, $projects);
        $this->assertIsArray($projects);

        $parameters = [
            'query' => $project->getName(),
        ];
        $projects = $this->projectRepository->findByParametersForFrontend($user, $parameters);
        $this->assertCount(1, $projects);
        $this->assertIsArray($projects);

        $parameters = [
            'query' => 'wrong email',
        ];
        $projects = $this->projectRepository->findByParametersForFrontend($user, $parameters);
        $this->assertCount(0, $projects);
        $this->assertIsArray($projects);
    }
}
