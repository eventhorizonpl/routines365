<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

final class AccountOperationControllerTest extends AbstractUiTestCase
{
    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/settings/account-operations/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Account operations")')->count() > 0
        );
    }
}
