<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Kpi;
use App\Factory\KpiFactory;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

final class KpiFactoryTest extends AbstractTestCase
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

    public function testConstruct()
    {
        $kpiFactory = new KpiFactory();

        $this->assertInstanceOf(KpiFactory::class, $kpiFactory);
    }

    public function testCreateKpi()
    {
        $kpiFactory = new KpiFactory();
        $kpi = $kpiFactory->createKpi();
        $this->assertInstanceOf(Kpi::class, $kpi);
    }

    public function testCreateKpiWithRequired()
    {
        $accountCounter = $this->faker->randomNumber;
        $accountOperationCounter = $this->faker->randomNumber;
        $date = new DateTimeImmutable();
        $goalCounter = $this->faker->randomNumber;
        $noteCounter = $this->faker->randomNumber;
        $profileCounter = $this->faker->randomNumber;
        $quoteCounter = $this->faker->randomNumber;
        $reminderCounter = $this->faker->randomNumber;
        $reminderMessageCounter = $this->faker->randomNumber;
        $routineCounter = $this->faker->randomNumber;
        $sentReminderCounter = $this->faker->randomNumber;
        $userCounter = $this->faker->randomNumber;
        $kpiFactory = new KpiFactory();
        $kpi = $kpiFactory->createKpiWithRequired(
            $accountCounter,
            $accountOperationCounter,
            $date,
            $goalCounter,
            $noteCounter,
            $profileCounter,
            $quoteCounter,
            $reminderCounter,
            $reminderMessageCounter,
            $routineCounter,
            $sentReminderCounter,
            $userCounter
        );
        $this->assertInstanceOf(Kpi::class, $kpi);
        $this->assertEquals($accountCounter, $kpi->getAccountCounter());
        $this->assertEquals($accountOperationCounter, $kpi->getAccountOperationCounter());
        $this->assertEquals($date, $kpi->getDate());
        $this->assertEquals($goalCounter, $kpi->getGoalCounter());
        $this->assertEquals($noteCounter, $kpi->getNoteCounter());
        $this->assertEquals($profileCounter, $kpi->getProfileCounter());
        $this->assertEquals($quoteCounter, $kpi->getQuoteCounter());
        $this->assertEquals($reminderCounter, $kpi->getReminderCounter());
        $this->assertEquals($reminderMessageCounter, $kpi->getReminderMessageCounter());
        $this->assertEquals($routineCounter, $kpi->getRoutineCounter());
        $this->assertEquals($sentReminderCounter, $kpi->getSentReminderCounter());
        $this->assertEquals($userCounter, $kpi->getUserCounter());
    }
}
