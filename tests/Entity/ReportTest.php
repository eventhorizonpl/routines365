<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Report;
use App\Enum\{ReportStatusEnum, ReportTypeEnum};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
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
        $this->assertSame($uuid, $report->__toString());
    }

    public function testGetId(): void
    {
        $report = new Report();
        $this->assertNull($report->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $report = new Report();
        $this->assertNull($report->getUuid());
        $report->setUuid($uuid);
        $this->assertSame($uuid, $report->getUuid());
        $this->assertIsString($report->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setUuid($uuid));
        $this->assertSame($uuid, $report->getUuid());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertNull($report->getCreatedAt());
        $report->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $report->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $report->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertNull($report->getDeletedAt());
        $report->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $report->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $report->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertNull($report->getUpdatedAt());
        $report->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $report->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $report->getUpdatedAt());
    }

    public function testAddData(): void
    {
        $data = [['test data']];
        $report = new Report();
        $report->setData($data);
        $this->assertSame($data, $report->getData());
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
        $this->assertSame($data, $report->getData());
        $this->assertIsArray($report->getData());
    }

    public function testSetData(): void
    {
        $data = [['test data']];
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setData($data));
        $this->assertSame($data, $report->getData());
    }

    public function testGetStatus(): void
    {
        $status = ReportStatusEnum::INITIAL;
        $report = new Report();
        $report->setStatus($status);
        $this->assertSame($status, $report->getStatus());
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
        $status = ReportStatusEnum::INITIAL;
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setStatus($status));
        $this->assertSame($status, $report->getStatus());
    }

    public function testGetType(): void
    {
        $type = ReportTypeEnum::POST_REMIND_MESSAGES;
        $report = new Report();
        $report->setType($type);
        $this->assertSame($type, $report->getType());
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
        $type = ReportTypeEnum::POST_REMIND_MESSAGES;
        $report = new Report();
        $this->assertInstanceOf(Report::class, $report->setType($type));
        $this->assertSame($type, $report->getType());
    }
}
