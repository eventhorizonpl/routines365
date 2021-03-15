<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Retention;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 * @coversNothing
 */
final class RetentionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $retention = new Retention();
        $this->assertInstanceOf(Retention::class, $retention);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $retention = new Retention();
        $retention->setUuid($uuid);
        $this->assertSame($uuid, $retention->__toString());
    }

    public function testGetId(): void
    {
        $retention = new Retention();
        $this->assertNull($retention->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $retention = new Retention();
        $this->assertNull($retention->getUuid());
        $retention->setUuid($uuid);
        $this->assertSame($uuid, $retention->getUuid());
        $this->assertIsString($retention->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $retention = new Retention();
        $this->assertInstanceOf(Retention::class, $retention->setUuid($uuid));
        $this->assertSame($uuid, $retention->getUuid());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $retention = new Retention();
        $this->assertNull($retention->getCreatedAt());
        $retention->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $retention->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $retention = new Retention();
        $this->assertInstanceOf(Retention::class, $retention->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $retention->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $retention = new Retention();
        $this->assertNull($retention->getDeletedAt());
        $retention->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $retention->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $retention = new Retention();
        $this->assertInstanceOf(Retention::class, $retention->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $retention->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $retention = new Retention();
        $this->assertNull($retention->getUpdatedAt());
        $retention->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $retention->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $retention = new Retention();
        $this->assertInstanceOf(Retention::class, $retention->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $retention->getUpdatedAt());
    }

    public function testGetData(): void
    {
        $data = ['test data'];
        $retention = new Retention();
        $retention->setData($data);
        $this->assertSame($data, $retention->getData());
        $this->assertIsArray($retention->getData());
    }

    public function testSetData(): void
    {
        $data = ['test data'];
        $retention = new Retention();
        $this->assertInstanceOf(Retention::class, $retention->setData($data));
        $this->assertSame($data, $retention->getData());
    }

    public function testGetDate(): void
    {
        $date = new DateTimeImmutable();
        $retention = new Retention();
        $retention->setDate($date);
        $this->assertSame($date, $retention->getDate());
    }

    public function testSetDate(): void
    {
        $date = new DateTimeImmutable();
        $retention = new Retention();
        $this->assertInstanceOf(Retention::class, $retention->setDate($date));
        $this->assertSame($date, $retention->getDate());
    }
}
