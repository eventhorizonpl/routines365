<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Reminder;
use App\Entity\ReminderMessage;
use App\Entity\Routine;
use App\Entity\SentReminder;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class SentReminderTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $sentReminder = new SentReminder();
        $sentReminder->setUuid($uuid);
        $this->assertEquals($uuid, $sentReminder->__toString());
    }

    public function testGetId(): void
    {
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getUuid());
        $sentReminder->setUuid($uuid);
        $this->assertEquals($uuid, $sentReminder->getUuid());
        $this->assertIsString($sentReminder->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setUuid($uuid));
        $this->assertEquals($uuid, $sentReminder->getUuid());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getCreatedAt());
        $sentReminder->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $sentReminder->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $sentReminder->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getDeletedAt());
        $sentReminder->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $sentReminder->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $sentReminder->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getUpdatedAt());
        $sentReminder->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $sentReminder->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $sentReminder->getUpdatedAt());
    }

    public function testGetReminder(): void
    {
        $reminder = new Reminder();
        $sentReminder = new SentReminder();
        $sentReminder->setReminder($reminder);
        $this->assertEquals($reminder, $sentReminder->getReminder());
    }

    public function testSetReminder(): void
    {
        $reminder = new Reminder();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setReminder($reminder));
        $this->assertEquals($reminder, $sentReminder->getReminder());
    }

    public function testAddReminderMessage(): void
    {
        $sentReminder = new SentReminder();
        $this->assertCount(0, $sentReminder->getReminderMessages());
        $reminderMessage1 = new ReminderMessage();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->addReminderMessage($reminderMessage1));
        $this->assertCount(1, $sentReminder->getReminderMessages());
        $reminderMessage2 = new ReminderMessage();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->addReminderMessage($reminderMessage2));
        $this->assertCount(2, $sentReminder->getReminderMessages());
        $deletedAt = new DateTimeImmutable();
        $reminderMessage2->setDeletedAt($deletedAt);
        $this->assertCount(1, $sentReminder->getReminderMessages());
    }

    public function testGetReminderMessages(): void
    {
        $sentReminder = new SentReminder();
        $this->assertCount(0, $sentReminder->getReminderMessages());
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->addReminderMessage($reminderMessage));
        $this->assertCount(1, $sentReminder->getReminderMessages());
    }

    public function testGetReminderMessagesAll(): void
    {
        $sentReminder = new SentReminder();
        $this->assertCount(0, $sentReminder->getReminderMessagesAll());
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->addReminderMessage($reminderMessage));
        $this->assertCount(1, $sentReminder->getReminderMessagesAll());
        $deletedAt = new DateTimeImmutable();
        $reminderMessage->setDeletedAt($deletedAt);
        $this->assertCount(1, $sentReminder->getReminderMessagesAll());
    }

    public function testRemoveReminderMessage(): void
    {
        $sentReminder = new SentReminder();
        $this->assertCount(0, $sentReminder->getReminderMessages());
        $reminderMessage1 = new ReminderMessage();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->addReminderMessage($reminderMessage1));
        $this->assertCount(1, $sentReminder->getReminderMessages());
        $reminderMessage2 = new ReminderMessage();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->addReminderMessage($reminderMessage2));
        $this->assertCount(2, $sentReminder->getReminderMessages());
        $this->assertInstanceOf(SentReminder::class, $sentReminder->removeReminderMessage($reminderMessage1));
    }

    public function testGetRoutine(): void
    {
        $routine = new Routine();
        $sentReminder = new SentReminder();
        $sentReminder->setRoutine($routine);
        $this->assertEquals($routine, $sentReminder->getRoutine());
    }

    public function testSetRoutine(): void
    {
        $routine = new Routine();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setRoutine($routine));
        $this->assertEquals($routine, $sentReminder->getRoutine());
    }
}
