<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

final class HomeControllerTest extends AbstractUiTestCase
{
    public function testIndex(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h2:contains("We help. You achieve.")')->count() > 0
        );
    }
}
