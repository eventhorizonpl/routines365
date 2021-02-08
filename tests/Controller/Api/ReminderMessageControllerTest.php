<?php

declare(strict_types=1);

namespace App\Tests\Controller\Security;

use App\Tests\AbstractUiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class ReminderMessageControllerTest extends AbstractUiTestCase
{
    public function testGetBrowserNotificationsList(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/api/v1/reminder-messages/browser-notifications-list', [], [], [
            'HTTP_HOST' => 'api.routines365.local',
        ]);
        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $content['code']);
        $this->assertEquals('success', $content['status']);
        $this->assertEquals([], $content['data']);

        $this->purge();
        $user = $this->createAndLoginRich();

        $crawler = $this->client->request('GET', '/api/v1/reminder-messages/browser-notifications-list', [], [], [
            'HTTP_HOST' => 'api.routines365.local',
        ]);
        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $content['code']);
        $this->assertEquals('success', $content['status']);
        $this->assertCount(1, $content['data']);
    }
}
