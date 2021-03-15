<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class AchievementControllerTest extends AbstractUiTestCase
{
    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/achievements');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Achievements")')->count() > 0
        );
    }
}
