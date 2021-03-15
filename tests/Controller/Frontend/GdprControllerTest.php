<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class GdprControllerTest extends AbstractUiTestCase
{
    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/settings/gdpr/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("GDPR data export")')->count() > 0
        );
    }

    public function testExport(): void
    {
        $this->purge();
        $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/settings/gdpr/export');

        $this->assertResponseIsSuccessful();
    }
}
