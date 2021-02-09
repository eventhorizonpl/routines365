<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Kpi;
use App\Exception\ManagerException;
use App\Faker\UserFaker;
use App\Manager\KpiManager;
use App\Repository\KpiRepository;
use App\Service\KpiService;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class KpiManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?KpiManager $kpiManager;
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
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        unset(
            $this->kpiManager,
            $this->kpiRepository,
            $this->kpiService,
            $this->userFaker,
            $this->validator
        );

        parent::tearDown();
    }

    public function createKpi(): Kpi
    {
        $user = $this->userFaker->createRichUserPersisted();
        $kpi = $this->kpiService->create();

        return $kpi;
    }

    public function testConstruct(): void
    {
        $kpiManager = new KpiManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(KpiManager::class, $kpiManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $kpi = $this->createKpi();
        $accountCounter = 987;
        $kpi->setAccountCounter($accountCounter);
        $kpiId = $kpi->getId();
        $kpis = [];
        $kpis[] = $kpi;

        $kpiManager = $this->kpiManager->bulkSave($kpis, 1);
        $this->assertInstanceOf(KpiManager::class, $kpiManager);

        $kpi2 = $this->kpiRepository->findOneById($kpiId);
        $this->assertInstanceOf(Kpi::class, $kpi2);
        $this->assertEquals($accountCounter, $kpi2->getAccountCounter());
    }

    public function testDelete(): void
    {
        $this->purge();
        $kpi = $this->createKpi();
        $kpiId = $kpi->getId();

        $kpiManager = $this->kpiManager->delete($kpi);
        $this->assertInstanceOf(KpiManager::class, $kpiManager);

        $kpi2 = $this->kpiRepository->findOneById($kpiId);
        $this->assertNull($kpi2);
    }

    public function testSave(): void
    {
        $this->purge();
        $kpi = $this->createKpi();

        $kpiManager = $this->kpiManager->save($kpi, true);
        $this->assertInstanceOf(KpiManager::class, $kpiManager);

        $kpiManager = $this->kpiManager->save($kpi);
        $this->assertInstanceOf(KpiManager::class, $kpiManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $kpi = $this->createKpi();
        $kpi->setAccountCounter(-1);

        $kpiManager = $this->kpiManager->save($kpi, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $kpi = $this->createKpi();
        $kpiId = $kpi->getId();

        $kpiManager = $this->kpiManager->softDelete($kpi);
        $this->assertInstanceOf(KpiManager::class, $kpiManager);

        $kpi2 = $this->kpiRepository->findOneById($kpiId);
        $this->assertInstanceOf(Kpi::class, $kpi2);
        $this->assertTrue(null !== $kpi2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $kpi = $this->createKpi();
        $kpiId = $kpi->getId();

        $kpiManager = $this->kpiManager->softDelete($kpi);
        $this->assertInstanceOf(KpiManager::class, $kpiManager);

        $kpi2 = $this->kpiRepository->findOneById($kpiId);
        $this->assertInstanceOf(Kpi::class, $kpi2);
        $this->assertTrue(null !== $kpi2->getDeletedAt());

        $kpiManager = $this->kpiManager->undelete($kpi);
        $this->assertInstanceOf(KpiManager::class, $kpiManager);

        $kpi3 = $this->kpiRepository->findOneById($kpiId);
        $this->assertInstanceOf(Kpi::class, $kpi3);
        $this->assertTrue(null === $kpi3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $kpi = $this->createKpi();

        $errors = $this->kpiManager->validate($kpi);
        $this->assertCount(0, $errors);

        $kpi->setAccountCounter(-1);
        $errors = $this->kpiManager->validate($kpi);
        $this->assertCount(1, $errors);
    }
}
