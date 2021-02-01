<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Report;
use Symfony\Component\Uid\Uuid;

class ReportFactory
{
    public function createReport(): Report
    {
        $report = new Report();
        $report->setUuid((string) Uuid::v4());

        return $report;
    }

    public function createReportWithRequired(
        array $data,
        string $status,
        string $type
    ): Report {
        $report = $this->createReport();

        $report
            ->setData($data)
            ->setStatus($status)
            ->setType($type);

        return $report;
    }
}
