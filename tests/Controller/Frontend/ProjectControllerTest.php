<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\{Project, User};
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class ProjectControllerTest extends AbstractUiTestCase
{
    public function createProject(User $user): Project
    {
        return $user->getProjects()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/projects/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('p:contains("You do not have any projects!")')->count() > 0
        );
    }

    public function testIndex2(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $project = $this->createProject($user);

        $crawler = $this->client->request('GET', '/projects/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$project->getName().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/projects/new');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a project")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseStatusCodeSame(422);
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $name = 'test name';
        $description = 'test description';
        $crawler = $this->client->submitForm('Save', [
            'project[name]' => $name,
            'project[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$description.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $project = $this->createProject($user);

        $crawler = $this->client->request(
            'GET',
            '/projects/'.$project->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("'.$project->getName().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$project->getDescription().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $project = $this->createProject($user);

        $crawler = $this->client->request('GET', '/projects/'.$project->getUuid().'/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a project")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is completed")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );

        $name = 'test name';
        $description = 'test description';
        $crawler = $this->client->submitForm('Update', [
            'project[name]' => $name,
            'project[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$description.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $project = $this->createProject($user);

        $crawler = $this->client->request('GET', '/projects/'.$project->getUuid().'/edit');

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            0 === $crawler->filter('div:contains("'.$project->getName().'")')->count()
        );
    }
}
