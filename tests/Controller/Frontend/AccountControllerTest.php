<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

final class AccountControllerTest extends AbstractUiTestCase
{
    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/settings/account/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Account details")')->count() > 0
        );

        $this->assertTrue(
            $crawler->filter('h5:contains("Account operations")')->count() > 0
        );
    }
}
