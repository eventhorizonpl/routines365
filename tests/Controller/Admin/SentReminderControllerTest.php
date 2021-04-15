<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\SentReminder;
use App\Manager\SentReminderManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class SentReminderControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?SentReminderManager $sentReminderManager;

    protected function tearDown(): void
    {
        $this->sentReminderManager = null;

        parent::tearDown();
    }

    public function createSentReminder(): SentReminder
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getRoutines()->first()->getSentReminders()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $sentReminder = $this->createSentReminder();

        $crawler = $this->client->request('GET', '/admin/sent-reminder/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Sent reminders")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Reminder")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Routine")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Updated at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$sentReminder->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$sentReminder->getRoutine()->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $sentReminder = $this->createSentReminder();

        $crawler = $this->client->request(
            'GET',
            '/admin/sent-reminder/'.$sentReminder->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Relations")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$sentReminder->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $sentReminder = $this->createSentReminder();
        $this->sentReminderManager->softDelete($sentReminder, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/sent-reminder/'.$sentReminder->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Sent reminders")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$sentReminder->getUuid().'")')->count() > 0
        );
    }
}
