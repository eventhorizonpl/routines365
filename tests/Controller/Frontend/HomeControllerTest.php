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
        $this->assertSelectorTextContains('h2', 'We help. You achieve.');
    }
}
