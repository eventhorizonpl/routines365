<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\ReminderMessage;
use App\Manager\ReminderMessageManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ReminderMessageControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?ReminderMessageManager $reminderMessageManager;

    protected function tearDown(): void
    {
        $this->reminderMessageManager = null;

        parent::tearDown();
    }

    public function createReminderMessage(): ReminderMessage
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getReminders()->first()->getReminderMessages()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $reminderMessage = $this->createReminderMessage();

        $crawler = $this->client->request('GET', '/admin/reminder-message/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Reminder messages")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Content")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Post date")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Updated at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reminderMessage->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reminderMessage->getReminder()->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $reminderMessage = $this->createReminderMessage();

        $crawler = $this->client->request(
            'GET',
            '/admin/reminder-message/'.$reminderMessage->getUuid()
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
            $crawler->filter('td:contains("'.$reminderMessage->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $reminderMessage = $this->createReminderMessage();
        $this->reminderMessageManager->softDelete($reminderMessage, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/reminder-message/'.$reminderMessage->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Reminder messages")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reminderMessage->getUuid().'")')->count() > 0
        );
    }
}
