<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Factory\CronJobFactory;
use App\Tests\AbstractTestCase;
use Cron\CronBundle\Entity\CronJob;
use Faker\Factory;
use Faker\Generator;

final class CronJobFactoryTest extends AbstractTestCase
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
        $cronJobFactory = new CronJobFactory();

        $this->assertInstanceOf(CronJobFactory::class, $cronJobFactory);
    }

    public function testCreateCronJob(): void
    {
        $cronJobFactory = new CronJobFactory();
        $cronJob = $cronJobFactory->createCronJob();
        $this->assertInstanceOf(CronJob::class, $cronJob);
    }

    public function testCreateCronJobWithRequired(): void
    {
        $command = $this->faker->sentence;
        $description = $this->faker->sentence;
        $enabled = $this->faker->boolean;
        $name = $this->faker->sentence;
        $schedule = $this->faker->sentence;
        $cronJobFactory = new CronJobFactory();
        $cronJob = $cronJobFactory->createCronJobWithRequired(
            $command,
            $description,
            $enabled,
            $name,
            $schedule
        );
        $this->assertInstanceOf(CronJob::class, $cronJob);
        $this->assertEquals($command, $cronJob->getCommand());
        $this->assertEquals($description, $cronJob->getDescription());
        $this->assertEquals($enabled, $cronJob->getEnabled());
        $this->assertEquals($name, $cronJob->getName());
        $this->assertEquals($schedule, $cronJob->getSchedule());
    }
}
