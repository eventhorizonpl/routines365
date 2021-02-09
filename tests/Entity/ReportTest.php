<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Report;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final class ReportTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $report = new Report();
        $report->setUuid($uuid);
        $this->assertEquals($uuid, $report->__toString());
    }

    public function testGetId(): void
    {
        $report = new Report();
        $this->assertEquals(null, $report->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $report = new Report();
        $this->assertEquals(null, $report->getUuid());
        $report->setUuid($uuid);
        $this->assertEquals($uuid, $report->getUuid());
        $this->assertIsString($report->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setUuid($uuid));
        $this->assertEquals($uuid, $report->getUuid());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertEquals(null, $report->getCreatedAt());
        $report->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $report->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $report->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertEquals(null, $report->getDeletedAt());
        $report->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $report->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $report->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertEquals(null, $report->getUpdatedAt());
        $report->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $report->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $report->getUpdatedAt());
    }

    public function testAddData(): void
    {
        $data = [['test data']];
        $report = new Report();
        $report->setData($data);
        $this->assertEquals($data, $report->getData());
        $this->assertCount(1, $report->getData());
        $this->assertIsArray($report->getData());
        $report->addData(['test data']);
        $this->assertCount(2, $report->getData());
    }

    public function testGetData(): void
    {
        $data = [['test data']];
        $report = new Report();
        $report->setData($data);
        $this->assertEquals($data, $report->getData());
        $this->assertIsArray($report->getData());
    }

    public function testSetData(): void
    {
        $data = [['test data']];
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setData($data));
        $this->assertEquals($data, $report->getData());
    }

    public function testGetStatus(): void
    {
        $status = Report::STATUS_INITIAL;
        $report = new Report();
        $report->setStatus($status);
        $this->assertEquals($status, $report->getStatus());
        $this->assertIsString($report->getStatus());
    }

    public function testGetStatusFormChoices(): void
    {
        $this->assertCount(3, Report::getStatusFormChoices());
        $this->assertIsArray(Report::getStatusFormChoices());
    }

    public function testGetStatusValidationChoices(): void
    {
        $this->assertCount(3, Report::getStatusValidationChoices());
        $this->assertIsArray(Report::getStatusValidationChoices());
    }

    public function testSetStatus(): void
    {
        $status = Report::STATUS_INITIAL;
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setStatus($status));
        $this->assertEquals($status, $report->getStatus());
    }

    public function testSetStatusException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $status = 'wrong status';
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setStatus($status));
    }

    public function testGetType(): void
    {
        $type = Report::TYPE_POST_REMIND_MESSAGES;
        $report = new Report();
        $report->setType($type);
        $this->assertEquals($type, $report->getType());
        $this->assertIsString($report->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(1, Report::getTypeFormChoices());
        $this->assertIsArray(Report::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(1, Report::getTypeValidationChoices());
        $this->assertIsArray(Report::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = Report::TYPE_POST_REMIND_MESSAGES;
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setType($type));
        $this->assertEquals($type, $report->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setType($type));
    }
}