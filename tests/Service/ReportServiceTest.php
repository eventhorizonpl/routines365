<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Report;
use App\Factory\ReportFactory;
use App\Manager\ReportManager;
use App\Service\ReportService;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 * @coversNothing
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
        $status = Report::STATUS_FINISHED;
        $type = Report::TYPE_POST_REMIND_MESSAGES;
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
        $status = Report::STATUS_FINISHED;
        $type = Report::TYPE_POST_REMIND_MESSAGES;
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
        $this->assertSame(Report::STATUS_IN_PROGRESS, $report->getStatus());
    }

    public function testCreatePostRemindMessages(): void
    {
        $this->purge();

        $report = $this->reportService->createPostRemindMessages();
        $this->assertInstanceOf(Report::class, $report);
        $this->assertSame([], $report->getData());
        $this->assertSame(Report::STATUS_INITIAL, $report->getStatus());
        $this->assertSame(Report::TYPE_POST_REMIND_MESSAGES, $report->getType());
    }

    public function testFinish(): void
    {
        $this->purge();

        $data = [['test']];
        $status = Report::STATUS_IN_PROGRESS;
        $type = Report::TYPE_POST_REMIND_MESSAGES;
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
        $this->assertSame(Report::STATUS_FINISHED, $report->getStatus());
    }
}
