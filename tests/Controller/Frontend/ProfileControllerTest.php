<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

final class ProfileControllerTest extends AbstractUiTestCase
{
    public function testShow(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();

        $crawler = $this->client->request('GET', '/settings/profile/');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Profile details")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$user->getEmail().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$user->getProfile()->getFirstName().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$user->getProfile()->getLastName().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();

        $crawler = $this->client->request('GET', '/settings/profile/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit profile")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Time zone")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Theme")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Send weekly monthly statistics")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Show motivational messages")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("First name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Last name")')->count() > 0
        );

        $firstName = 'John';
        $lastName = 'Doe';
        $crawler = $this->client->submitForm('Update', [
            'profile[firstName]' => $firstName,
            'profile[lastName]' => $lastName,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Profile details")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$firstName.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$lastName.'")')->count() > 0
        );
    }
}
