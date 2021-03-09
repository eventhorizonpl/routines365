<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Report;
use App\Manager\ReportManager;
use App\Service\ReportService;
use App\Tests\AbstractUiTestCase;

final class ReportControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?ReportManager $reportManager;
    /**
     * @inject
     */
    private ?ReportService $reportService;

    protected function tearDown(): void
    {
        unset(
            $this->reportManager,
            $this->reportService
        );

        parent::tearDown();
    }

    public function createReport(): Report
    {
        $report = $this->reportService->createPostRemindMessages();

        return $report;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $report = $this->createReport();

        $crawler = $this->client->request('GET', '/admin/report/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Reports")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Status")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Updated at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$report->getUuid().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $report = $this->createReport();

        $crawler = $this->client->request(
            'GET',
            '/admin/report/'.$report->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$report->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $report = $this->createReport();
        $this->reportManager->softDelete($report, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/report/'.$report->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Reports")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$report->getUuid().'")')->count() > 0
        );
    }
}
