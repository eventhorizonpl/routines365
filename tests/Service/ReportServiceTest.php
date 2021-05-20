<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Report;
use App\Enum\{ReportStatusEnum, ReportTypeEnum};
use App\Factory\ReportFactory;
use App\Manager\ReportManager;
use App\Service\ReportService;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class ReportServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ReportFactory $reportFactory;
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
        $this->reportFactory = null;
        $this->reportManager = null;
        $this->reportService = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $reportService = new ReportService($this->reportFactory, $this->reportManager);

        $this->assertInstanceOf(ReportService::class, $reportService);
    }

    public function testCreate(): void
    {
        $this->purge();

        $data = ['test'];
        $status = ReportStatusEnum::FINISHED;
        $type = ReportTypeEnum::POST_REMIND_MESSAGES;
        $report = $this->reportService->create(
            $data,
            $status,
            $type
        );
        $this->assertInstanceOf(Report::class, $report);
        $this->assertSame($data, $report->getData());
        $this->assertSame($status, $report->getStatus());
        $this->assertSame($type, $report->getType());
    }

    public function testAddData(): void
    {
        $this->purge();

        $data = [['test']];
        $status = ReportStatusEnum::FINISHED;
        $type = ReportTypeEnum::POST_REMIND_MESSAGES;
        $report = $this->reportService->create(
            $data,
            $status,
            $type
        );
        $this->assertInstanceOf(Report::class, $report);
        $this->assertCount(1, $report->getData());
        $this->assertSame($data, $report->getData());
        $this->assertSame($status, $report->getStatus());
        $this->assertSame($type, $report->getType());

        $report = $this->reportService->addData(
            ['test 2'],
            $report
        );

        $this->assertInstanceOf(Report::class, $report);
        $this->assertCount(2, $report->getData());
        $this->assertSame(ReportStatusEnum::IN_PROGRESS, $report->getStatus());
    }

    public function testCreatePostRemindMessages(): void
    {
        $this->purge();

        $report = $this->reportService->createPostRemindMessages();
        $this->assertInstanceOf(Report::class, $report);
        $this->assertSame([], $report->getData());
        $this->assertSame(ReportStatusEnum::INITIAL, $report->getStatus());
        $this->assertSame(ReportTypeEnum::POST_REMIND_MESSAGES, $report->getType());
    }

    public function testFinish(): void
    {
        $this->purge();

        $data = [['test']];
        $status = ReportStatusEnum::IN_PROGRESS;
        $type = ReportTypeEnum::POST_REMIND_MESSAGES;
        $report = $this->reportService->create(
            $data,
            $status,
            $type
        );
        $this->assertInstanceOf(Report::class, $report);
        $this->assertCount(1, $report->getData());
        $this->assertSame($data, $report->getData());
        $this->assertSame($status, $report->getStatus());
        $this->assertSame($type, $report->getType());

        $report = $this->reportService->finish($report);

        $this->assertInstanceOf(Report::class, $report);
        $this->assertSame(ReportStatusEnum::FINISHED, $report->getStatus());
    }
}
