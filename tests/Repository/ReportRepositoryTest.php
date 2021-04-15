<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Faker\UserFaker;
use App\Repository\ReportRepository;
use App\Service\ReportService;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @internal
 */
final class ReportRepositoryTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ReportRepository $reportRepository;
    /**
     * @inject
     */
    private ?ReportService $reportService;
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
        $this->reportRepository = null;
        $this->reportService = null;
        $this->managerRegistry = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $reportRepository = new ReportRepository($this->managerRegistry);

        $this->assertInstanceOf(ReportRepository::class, $reportRepository);
    }

    public function testFindByParametersForAdmin(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $this->reportService->createPostRemindMessages();

        $reports = $this->reportRepository->findByParametersForAdmin()->getResult();
        $this->assertTrue(\count($reports) >= 1);
        $this->assertIsArray($reports);

        $parameters = [
            'type' => 'wrong',
        ];
        $reports = $this->reportRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $reports);
        $this->assertIsArray($reports);

        $parameters = [
            'status' => 'wrong',
        ];
        $reports = $this->reportRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $reports);
        $this->assertIsArray($reports);

        $parameters = [
            'ends_at' => new DateTimeImmutable('NOW'),
        ];
        $reports = $this->reportRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertTrue(\count($reports) >= 1);
        $this->assertIsArray($reports);

        $parameters = [
            'starts_at' => new DateTimeImmutable('+1 minute'),
        ];
        $reports = $this->reportRepository->findByParametersForAdmin($parameters)->getResult();
        $this->assertCount(0, $reports);
        $this->assertIsArray($reports);
    }
}
