<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class LandingPageControllerTest extends AbstractUiTestCase
{
    public function testIndex(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/landing-page/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Landing pages")')->count() > 0
        );
    }

    public function testLearnFaster(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/landing-page/learn-faster');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("7 quick and easy ways to learn faster")')->count() > 0
        );
    }
}
