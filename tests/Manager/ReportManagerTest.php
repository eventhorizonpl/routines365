<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Report;
use App\Exception\ManagerException;
use App\Manager\ReportManager;
use App\Repository\ReportRepository;
use App\Service\ReportService;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ReportManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ReportManager $reportManager;
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
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        unset(
            $this->reportManager,
            $this->reportRepository,
            $this->reportService,
            $this->validator
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $reportManager = new ReportManager($this->entityManager, $this->validator);

        $this->assertInstanceOf(ReportManager::class, $reportManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $status = Report::STATUS_FINISHED;
        $report = $this->reportService->createPostRemindMessages();
        $report->setStatus($status);
        $reportId = $report->getId();
        $reports = [];
        $reports[] = $report;

        $reportManager = $this->reportManager->bulkSave($reports, 1);
        $this->assertInstanceOf(ReportManager::class, $reportManager);

        $report2 = $this->reportRepository->findOneById($reportId);
        $this->assertInstanceOf(Report::class, $report2);
        $this->assertEquals($status, $report2->getStatus());
    }

    public function testDelete(): void
    {
        $this->purge();
        $report = $this->reportService->createPostRemindMessages();
        $reportId = $report->getId();

        $reportManager = $this->reportManager->delete($report);
        $this->assertInstanceOf(ReportManager::class, $reportManager);

        $report2 = $this->reportRepository->findOneById($reportId);
        $this->assertNull($report2);
    }

    public function testSave(): void
    {
        $this->purge();
        $report = $this->reportService->createPostRemindMessages();

        $reportManager = $this->reportManager->save($report, true);
        $this->assertInstanceOf(ReportManager::class, $reportManager);

        $reportManager = $this->reportManager->save($report);
        $this->assertInstanceOf(ReportManager::class, $reportManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $report = $this->reportService->createPostRemindMessages();
        $report->setUuid('wrong');

        $reportManager = $this->reportManager->save($report, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $report = $this->reportService->createPostRemindMessages();
        $reportId = $report->getId();

        $reportManager = $this->reportManager->softDelete($report);
        $this->assertInstanceOf(ReportManager::class, $reportManager);

        $report2 = $this->reportRepository->findOneById($reportId);
        $this->assertInstanceOf(Report::class, $report2);
        $this->assertTrue(null !== $report2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $report = $this->reportService->createPostRemindMessages();
        $reportId = $report->getId();

        $reportManager = $this->reportManager->softDelete($report);
        $this->assertInstanceOf(ReportManager::class, $reportManager);

        $report2 = $this->reportRepository->findOneById($reportId);
        $this->assertInstanceOf(Report::class, $report2);
        $this->assertTrue(null !== $report2->getDeletedAt());

        $reportManager = $this->reportManager->undelete($report);
        $this->assertInstanceOf(ReportManager::class, $reportManager);

        $report3 = $this->reportRepository->findOneById($reportId);
        $this->assertInstanceOf(Report::class, $report3);
        $this->assertTrue(null === $report3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $report = $this->reportService->createPostRemindMessages();

        $errors = $this->reportManager->validate($report);
        $this->assertCount(0, $errors);

        $report->setUuid('wrong');
        $errors = $this->reportManager->validate($report);
        $this->assertCount(1, $errors);
    }
}
