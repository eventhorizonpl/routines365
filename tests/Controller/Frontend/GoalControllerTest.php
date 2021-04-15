<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\{Goal, Project, Routine, User};
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GoalControllerTest extends AbstractUiTestCase
{
    public function createRoutineGoal(User $user): Goal
    {
        return $user->getRoutines()->first()->getGoals()->first();
    }

    public function createProjectGoal(User $user): Goal
    {
        return $user->getProjects()->first()->getGoals()->first();
    }

    public function createProject(User $user): Project
    {
        return $user->getProjects()->first();
    }

    public function createRoutine(User $user): Routine
    {
        return $user->getRoutines()->first();
    }

    public function testNewRoutine(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request('GET', '/goals/'.$routine->getUuid().'/routine/new');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a goal")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Routine")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Project")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $name = 'test name';
        $description = 'test description';
        $crawler = $this->client->submitForm('Save', [
            'goal[name]' => $name,
            'goal[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$description.'")')->count() > 0
        );
    }

    public function testNewProject(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $project = $this->createProject($user);

        $crawler = $this->client->request('GET', '/goals/'.$project->getUuid().'/project/new');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a goal")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Routine")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Project")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $name = 'test name';
        $description = 'test description';
        $crawler = $this->client->submitForm('Save', [
            'goal[name]' => $name,
            'goal[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$description.'")')->count() > 0
        );
    }

    public function testCompleteRoutine(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $goal = $this->createRoutineGoal($user);

        $crawler = $this->client->request('GET', '/goals/'.$goal->getUuid().'/routine/complete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Congratulations for achieving your goal!")')->count() > 0
        );
    }

    public function testCompleteProject(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $goal = $this->createProjectGoal($user);

        $crawler = $this->client->request('GET', '/goals/'.$goal->getUuid().'/project/complete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Congratulations for achieving your goal!")')->count() > 0
        );
    }

    public function testEditRoutine(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $goal = $this->createRoutineGoal($user);

        $crawler = $this->client->request('GET', '/goals/'.$goal->getUuid().'/routine/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a goal")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Routine")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Project")')->count() > 0
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
            'goal[name]' => $name,
            'goal[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$description.'")')->count() > 0
        );
    }

    public function testEditProject(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $goal = $this->createProjectGoal($user);

        $crawler = $this->client->request('GET', '/goals/'.$goal->getUuid().'/project/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a goal")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Routine")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Project")')->count() > 0
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
            'goal[name]' => $name,
            'goal[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$description.'")')->count() > 0
        );
    }

    public function testDeleteRoutine(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $goal = $this->createRoutineGoal($user);

        $crawler = $this->client->request('GET', '/goals/'.$goal->getUuid().'/routine/edit');

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            0 === $crawler->filter('td:contains("'.$goal->getName().'")')->count()
        );
    }

    public function testDeleteProject(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $goal = $this->createProjectGoal($user);

        $crawler = $this->client->request('GET', '/goals/'.$goal->getUuid().'/project/edit');

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            0 === $crawler->filter('td:contains("'.$goal->getName().'")')->count()
        );
    }
}
