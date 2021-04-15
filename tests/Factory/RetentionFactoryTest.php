<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Retention;
use App\Factory\RetentionFactory;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Faker\{Factory, Generator};

/**
 * @internal
 * @coversNothing
 */
final class RetentionFactoryTest extends AbstractTestCase
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
        $retentionFactory = new RetentionFactory();

        $this->assertInstanceOf(RetentionFactory::class, $retentionFactory);
    }

    public function testCreateRetention(): void
    {
        $retentionFactory = new RetentionFactory();
        $retention = $retentionFactory->createRetention();
        $this->assertInstanceOf(Retention::class, $retention);
    }

    public function testCreateRetentionWithRequired(): void
    {
        $data = $this->faker->rgbColorAsArray();
        $date = new DateTimeImmutable();
        $retentionFactory = new RetentionFactory();
        $retention = $retentionFactory->createRetentionWithRequired(
            $data,
            $date
        );
        $this->assertInstanceOf(Retention::class, $retention);
        $this->assertSame($data, $retention->getData());
        $this->assertSame($date, $retention->getDate());
    }
}
