<?php

declare(strict_types=1);

namespace App\Tests\Controller\Security;

use App\Faker\UserFaker;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class SecurityControllerTest extends AbstractUiTestCase
{
    public function testLogin(): void
    {
        $this->purge();
        $this->createRegular();

        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Login")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Remember me")')->count() > 0
        );

        $crawler = $this->client->submitForm('Login');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Email could not be found.")')->count() > 0
        );

        $crawler = $this->client->submitForm('Login', [
            'email' => UserFaker::CUSTOMER_EMAIL,
            'password' => UserFaker::CUSTOMER_PASSWORD,
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('p:contains("You do not have any routines!")')->count() > 0
        );
    }

    public function testLogin2(): void
    {
        $this->purge();
        $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('h2:contains("We help. You achieve.")')->count() > 0
        );
    }

    public function testLogout(): void
    {
        $this->purge();
        $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/logout');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('h2:contains("We help. You achieve.")')->count() > 0
        );
    }
}
