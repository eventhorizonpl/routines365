<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\KpiRepository;
use App\Service\KpiService;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 * @coversNothing
 */
final class KpiRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?KpiRepository $kpiRepository;
    /**
     * @inject
     */
    private ?KpiService $kpiService;
    /**
     * @inject
     */
    private ?ManagerRegistry $managerRegistry;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->kpiRepository = null;
        $this->kpiService = null;
        $this->managerRegistry = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $kpiRepository = new KpiRepository($this->managerRegistry);

        $this->assertInstanceOf(KpiRepository::class, $kpiRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->kpiService->create();

        $kpis = $this->kpiRepository->findByParametersForAdmin()->getResult();
        $this->assertTrue(\count($kpis) >= 1);
        $this->assertIsArray($kpis);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $kpis = $this->kpiRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertTrue(\count($kpis) >= 1);
        $this->assertIsArray($kpis);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $kpis = $this->kpiRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $kpis);
        $this->assertIsArray($kpis);
    }
}
