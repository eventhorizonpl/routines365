<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Kpi;
use App\Manager\KpiManager;
use App\Service\KpiService;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class KpiControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?KpiManager $kpiManager;
    /**
     * @inject
     */
    private ?KpiService $kpiService;

    protected function tearDown(): void
    {
        $this->kpiManager = null;
        $this->kpiService = null
        ;

        parent::tearDown();
    }

    public function createKpi(): Kpi
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $this->kpiService->create();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $kpi = $this->createKpi();

        $crawler = $this->client->request('GET', '/admin/kpi/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("KPIs")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Date")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Deleted at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Updated at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$kpi->getUuid().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $kpi = $this->createKpi();

        $crawler = $this->client->request(
            'GET',
            '/admin/kpi/'.$kpi->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$kpi->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $kpi = $this->createKpi();
        $this->kpiManager->softDelete($kpi, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/kpi/'.$kpi->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("KPIs")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$kpi->getUuid().'")')->count() > 0
        );
    }
}
