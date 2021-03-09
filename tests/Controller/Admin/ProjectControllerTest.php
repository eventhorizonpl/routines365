<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Project;
use App\Manager\ProjectManager;
use App\Tests\AbstractUiTestCase;

final class ProjectControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?ProjectManager $projectManager;

    protected function tearDown(): void
    {
        unset($this->projectManager);

        parent::tearDown();
    }

    public function createProject(): Project
    {
        $user = $this->userFaker->createRichUserPersisted();
        $project = $user->getProjects()->first();

        return $project;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $project = $this->createProject();

        $crawler = $this->client->request('GET', '/admin/project/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Projects")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is completed")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Deleted at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Updated at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$project->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$project->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $project = $this->createProject();

        $crawler = $this->client->request(
            'GET',
            '/admin/project/'.$project->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Relations")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$project->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $project = $this->createProject();
        $this->projectManager->softDelete($project, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/project/'.$project->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Projects")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$project->getUuid().'")')->count() > 0
        );
    }
}
