<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Report;
use App\Enum\{ReportStatusEnum, ReportTypeEnum};
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
            ->setStatus(ReportStatusEnum::IN_PROGRESS)
        ;
        $this->reportManager->save($report);

        return $report;
    }

    public function create(
        array $data,
        ReportStatusEnum $status,
        ReportTypeEnum $type
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
        return $this->create(
            [],
            ReportStatusEnum::INITIAL,
            ReportTypeEnum::POST_REMIND_MESSAGES
        );
    }

    public function finish(
        Report $report
    ): Report {
        $report->setStatus(ReportStatusEnum::FINISHED);
        $this->reportManager->save($report);

        return $report;
    }
}
