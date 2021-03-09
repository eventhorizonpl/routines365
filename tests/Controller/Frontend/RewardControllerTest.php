<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\Reward;
use App\Entity\Routine;
use App\Entity\User;
use App\Tests\AbstractUiTestCase;

final class RewardControllerTest extends AbstractUiTestCase
{
    public function createReward(User $user): Reward
    {
        $reward = $user->getRewards()->first();

        return $reward;
    }

    public function createRoutine(User $user): Routine
    {
        $routine = $user->getRoutines()->first();

        return $routine;
    }

    public function testIndex(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/rewards/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('p:contains("You do not have any rewards!")')->count() > 0
        );

        $this->purge();
        $user = $this->createAndLoginRich();
        $reward = $this->createReward($user);

        $crawler = $this->client->request('GET', '/rewards/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$reward->getName().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();

        $crawler = $this->client->request('GET', '/rewards/new/default');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a reward")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Required number of completions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Routine")')->count() > 0
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
            'reward[name]' => $name,
            'reward[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$description.'")')->count() > 0
        );
    }

    public function testNewRoutine(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request('GET', '/rewards/new/routine/'.$routine->getUuid());

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a reward")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Required number of completions")')->count() > 0
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
            'reward[name]' => $name,
            'reward[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $reward = $this->createReward($user);

        $crawler = $this->client->request(
            'GET',
            '/rewards/'.$reward->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("'.$reward->getName().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$reward->getDescription().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $reward = $this->createReward($user);

        $crawler = $this->client->request('GET', '/rewards/'.$reward->getUuid().'/default/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a reward")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Required number of completions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );

        $name = 'test name';
        $description = 'test description';
        $crawler = $this->client->submitForm('Update', [
            'reward[name]' => $name,
            'reward[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$description.'")')->count() > 0
        );
    }

    public function testEditRoutine(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $reward = $this->createReward($user);

        $crawler = $this->client->request('GET', '/rewards/'.$reward->getUuid().'/routine/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a reward")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Required number of completions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );

        $name = 'test name';
        $description = 'test description';
        $crawler = $this->client->submitForm('Update', [
            'reward[name]' => $name,
            'reward[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $reward = $this->createReward($user);

        $crawler = $this->client->request('GET', '/rewards/'.$reward->getUuid().'/default/edit');

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            0 === $crawler->filter('div:contains("'.$reward->getName().'")')->count()
        );
    }
}
