<?php

declare(strict_types=1);

namespace App\Tests\Controller\Api;

use App\Tests\AbstractUiTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 * @coversNothing
 */
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

        $this->assertSame(Response::HTTP_OK, $content['code']);
        $this->assertSame('success', $content['status']);
        $this->assertSame([], $content['data']);

        $this->purge();
        $user = $this->createAndLoginRich();

        $crawler = $this->client->request('GET', '/api/v1/reminder-messages/browser-notifications-list', [], [], [
            'HTTP_HOST' => 'api.routines365.local',
        ]);
        $content = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertSame(Response::HTTP_OK, $content['code']);
        $this->assertSame('success', $content['status']);
        $this->assertCount(1, $content['data']);
    }
}
