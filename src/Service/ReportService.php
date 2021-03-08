<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Report;
use App\Factory\ReportFactory;
use App\Manager\ReportManager;

class ReportService
{
    public function __construct(
        private ReportFactory $reportFactory,
        private ReportManager $reportManager
    ) {
    }

    public function addData(
        array $data,
        Report $report
    ): Report {
        $report
            ->addData($data)
            ->setStatus(Report::STATUS_IN_PROGRESS);
        $this->reportManager->save($report);

        return $report;
    }

    public function create(
        array $data,
        string $status,
        string $type
    ): Report {
        $report = $this->reportFactory->createReportWithRequired(
            $data,
            $status,
            $type
        );

        $this->reportManager->save($report);

        return $report;
    }

    public function createPostRemindMessages(): Report
    {
        $report = $this->create(
            [],
            Report::STATUS_INITIAL,
            Report::TYPE_POST_REMIND_MESSAGES
        );

        return $report;
    }

    public function finish(
        Report $report
    ): Report {
        $report->setStatus(Report::STATUS_FINISHED);
        $this->reportManager->save($report);

        return $report;
    }
}
