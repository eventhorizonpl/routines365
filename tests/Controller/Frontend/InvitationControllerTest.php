<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class InvitationControllerTest extends AbstractUiTestCase
{
    public function testSend(): void
    {
        $this->purge();
        $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/invitations/send');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Edit profile")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("First name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Last name")')->count() > 0
        );

        $crawler = $this->client->submitForm('Update', [
            'profile[firstName]' => 'John',
            'profile[lastName]' => 'Doe',
        ]);

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->request('GET', '/invitations/send');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Send an invitation")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Email")')->count() > 0
        );

        $crawler = $this->client->submitForm('Send', [
            'invitation[email]' => 'test@example.org',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Email was sent. You can invite another person.")')->count() > 0
        );
    }
}
