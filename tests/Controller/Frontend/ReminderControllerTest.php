<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\{Reminder, Routine, User};
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class ReminderControllerTest extends AbstractUiTestCase
{
    public function createReminder(User $user): Reminder
    {
        return $user->getReminders()->first();
    }

    public function createRoutine(User $user): Routine
    {
        return $user->getRoutines()->first();
    }

    public function testNew(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request('GET', '/reminders/'.$routine->getUuid().'/new');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Edit profile")')->count() > 0
        );

        $crawler = $this->client->submitForm('Update', [
            'profile[timeZone]' => 'Europe/Warsaw',
        ]);

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->request('GET', '/reminders/'.$routine->getUuid().'/new');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a reminder")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Hour")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Minutes before")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Send email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Send motivational message")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('p:contains("Reminders: 2")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $reminder = $this->createReminder($user);

        $crawler = $this->client->request('GET', '/reminders/'.$reminder->getUuid().'/edit');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Edit profile")')->count() > 0
        );

        $crawler = $this->client->submitForm('Update', [
            'profile[timeZone]' => 'Europe/Warsaw',
        ]);

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->request('GET', '/reminders/'.$reminder->getUuid().'/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a reminder")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Hour")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Minutes before")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Send email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Send motivational message")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );

        $crawler = $this->client->submitForm('Update');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('p:contains("Reminders: 1")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $reminder = $this->createReminder($user);

        $crawler = $this->client->request('GET', '/reminders/'.$reminder->getUuid().'/edit');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Edit profile")')->count() > 0
        );

        $crawler = $this->client->submitForm('Update', [
            'profile[timeZone]' => 'Europe/Warsaw',
        ]);

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->request('GET', '/reminders/'.$reminder->getUuid().'/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a reminder")')->count() > 0
        );

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('p:contains("Reminders: 0")')->count() > 0
        );
    }
}
