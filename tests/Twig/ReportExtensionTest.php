<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\ReportExtension;

/**
 * @internal
 * @coversNothing
 */
final class ReportExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $reportExtension = new ReportExtension();

        $this->assertInstanceOf(ReportExtension::class, $reportExtension);
    }

    public function testGetFunctions(): void
    {
        $reportExtension = new ReportExtension();

        $this->assertCount(2, $reportExtension->getFunctions());
        $this->assertIsArray($reportExtension->getFunctions());
    }

    public function testReportStatus(): void
    {
        $reportExtension = new ReportExtension();

        $this->assertCount(3, $reportExtension->reportStatus());
        $this->assertIsArray($reportExtension->reportStatus());
    }

    public function testReportType(): void
    {
        $reportExtension = new ReportExtension();

        $this->assertCount(1, $reportExtension->reportType());
        $this->assertIsArray($reportExtension->reportType());
    }
}
