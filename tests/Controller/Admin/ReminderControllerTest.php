<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Reminder;
use App\Manager\ReminderManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ReminderControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?ReminderManager $reminderManager;

    protected function tearDown(): void
    {
        $this->reminderManager = null;

        parent::tearDown();
    }

    public function createReminder(): Reminder
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getReminders()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $reminder = $this->createReminder();

        $crawler = $this->client->request('GET', '/admin/reminder/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Reminders")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Hour")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Minutes before")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Next date")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Next date local time")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Previous date")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Send email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Send sms")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Send motivational message")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Type")')->count() > 0
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
            $crawler->filter('td:contains("'.$reminder->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reminder->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $reminder = $this->createReminder();

        $crawler = $this->client->request(
            'GET',
            '/admin/reminder/'.$reminder->getUuid()
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
            $crawler->filter('td:contains("'.$reminder->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $reminder = $this->createReminder();
        $this->reminderManager->softDelete($reminder, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/reminder/'.$reminder->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Reminders")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reminder->getUuid().'")')->count() > 0
        );
    }

    public function testUnlock(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $reminder = $this->createReminder();
        $this->reminderManager->lock($reminder);

        $crawler = $this->client->request(
            'GET',
            '/admin/reminder/'.$reminder->getUuid().'/unlock'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Reminders")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reminder->getUuid().'")')->count() > 0
        );
    }
}
