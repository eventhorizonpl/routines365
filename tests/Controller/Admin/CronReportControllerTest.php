<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Tests\AbstractUiTestCase;

final class CronReportControllerTest extends AbstractUiTestCase
{
    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();

        $crawler = $this->client->request('GET', '/admin/cron-report/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'Cron reports');
        $this->assertTrue(
            $crawler->filter('th:contains("ID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Job")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Run at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Run time")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Exit code")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Output")')->count() > 0
        );
    }
}
