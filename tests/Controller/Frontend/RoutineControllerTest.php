<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\{Routine, User};
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class RoutineControllerTest extends AbstractUiTestCase
{
    public function createRoutine(User $user): Routine
    {
        return $user->getRoutines()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/routines/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('p:contains("You do not have any routines!")')->count() > 0
        );
    }

    public function testIndex2(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request('GET', '/routines/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$routine->getName().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/routines/new');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a routine")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
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
            'routine[name]' => $name,
            'routine[description]' => $description,
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
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request(
            'GET',
            '/routines/'.$routine->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("'.$routine->getName().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$routine->getDescription().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("Completed routines:")')->count() > 0
        );
    }

    public function testShowGoals(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request(
            'GET',
            '/routines/'.$routine->getUuid().'/goals'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("'.$routine->getName().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$routine->getDescription().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("Goals:")')->count() > 0
        );
    }

    public function testShowNotes(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request(
            'GET',
            '/routines/'.$routine->getUuid().'/notes'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("'.$routine->getName().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$routine->getDescription().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("Notes:")')->count() > 0
        );
    }

    public function testShowReminders(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request(
            'GET',
            '/routines/'.$routine->getUuid().'/reminders'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("'.$routine->getName().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$routine->getDescription().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("Reminders:")')->count() > 0
        );
    }

    public function testShowRewards(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request(
            'GET',
            '/routines/'.$routine->getUuid().'/rewards'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("'.$routine->getName().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$routine->getDescription().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("Rewards:")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request('GET', '/routines/'.$routine->getUuid().'/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a routine")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );

        $name = 'test name';
        $description = 'test description';
        $crawler = $this->client->submitForm('Update', [
            'routine[name]' => $name,
            'routine[description]' => $description,
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
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request('GET', '/routines/'.$routine->getUuid().'/edit');

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            0 === $crawler->filter('div:contains("'.$routine->getName().'")')->count()
        );
    }
}
