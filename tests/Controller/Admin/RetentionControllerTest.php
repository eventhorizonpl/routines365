<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Retention;
use App\Manager\RetentionManager;
use App\Repository\RetentionRepository;
use App\Service\RetentionService;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class RetentionControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?RetentionManager $retentionManager;
    /**
     * @inject
     */
    private ?RetentionRepository $retentionRepository;
    /**
     * @inject
     */
    private ?RetentionService $retentionService;

    protected function tearDown(): void
    {
        $this->retentionManager = null;
        $this->retentionRepository = null;
        $this->retentionService = null
        ;

        parent::tearDown();
    }

    public function createRetention(): Retention
    {
        $user = $this->userFaker->createRichUserPersisted();
        $this->retentionService->run();
        $retentions = $this->retentionRepository->findAll();

        return $retentions[0];
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $retention = $this->createRetention();

        $crawler = $this->client->request('GET', '/admin/retention/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Retentions")')->count() > 0
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
            $crawler->filter('td:contains("'.$retention->getUuid().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $retention = $this->createRetention();

        $crawler = $this->client->request(
            'GET',
            '/admin/retention/'.$retention->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$retention->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $retention = $this->createRetention();
        $this->retentionManager->softDelete($retention, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/retention/'.$retention->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Retentions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$retention->getUuid().'")')->count() > 0
        );
    }
}
