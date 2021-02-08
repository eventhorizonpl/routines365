<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

final class LandingPageControllerTest extends AbstractUiTestCase
{
    public function testIndex(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/landing-page/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Landing pages');
    }

    public function testLearnFaster(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/landing-page/learn-faster');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', '7 quick and easy ways to learn faster');
    }
}
