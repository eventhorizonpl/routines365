<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Report;
use App\Factory\ReportFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

final class ReportFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $reportFactory = new ReportFactory();

        $this->assertInstanceOf(ReportFactory::class, $reportFactory);
    }

    public function testCreateReport(): void
    {
        $reportFactory = new ReportFactory();
        $report = $reportFactory->createReport();
        $this->assertInstanceOf(Report::class, $report);
    }

    public function testCreateReportWithRequired(): void
    {
        $data = $this->faker->words;
        $status = $this->faker->randomElement(
            Report::getStatusFormChoices()
        );
        $type = $this->faker->randomElement(
            Report::getTypeFormChoices()
        );
        $reportFactory = new ReportFactory();
        $report = $reportFactory->createReportWithRequired(
            $data,
            $status,
            $type
        );
        $this->assertInstanceOf(Report::class, $report);
        $this->assertEquals($data, $report->getData());
        $this->assertEquals($status, $report->getStatus());
        $this->assertEquals($type, $report->getType());
    }
}