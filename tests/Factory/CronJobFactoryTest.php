<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Factory\CronJobFactory;
use App\Tests\AbstractTestCase;
use Cron\CronBundle\Entity\CronJob;
use Faker\Factory;
use Faker\Generator;

/**
 * @internal
 * @coversNothing
 */
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
        $this->faker = null;

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
        $this->assertSame($command, $cronJob->getCommand());
        $this->assertSame($description, $cronJob->getDescription());
        $this->assertSame($enabled, $cronJob->getEnabled());
        $this->assertSame($name, $cronJob->getName());
        $this->assertSame($schedule, $cronJob->getSchedule());
    }
}
