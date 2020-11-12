<?php

namespace App\Tests\Entity;

use App\Entity\Reminder;
use App\Entity\ReminderMessage;
use App\Entity\Routine;
use App\Entity\SentReminder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class SentReminderTest extends TestCase
{
    public function testConstruct()
    {
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder);
    }

    public function testToString()
    {
        $uuid = Uuid::v4();
        $sentReminder = new SentReminder();
        $sentReminder->setUuid($uuid);
        $this->assertEquals($uuid, $sentReminder->__toString());
    }

    public function testGetId()
    {
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getId());
    }

    public function testGetUuid()
    {
        $uuid = Uuid::v4();
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getUuid());
        $sentReminder->setUuid($uuid);
        $this->assertEquals($uuid, $sentReminder->getUuid());
        $this->assertIsString($sentReminder->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = Uuid::v4();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setUuid($uuid));
        $this->assertEquals($uuid, $sentReminder->getUuid());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getCreatedAt());
        $sentReminder->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $sentReminder->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $sentReminder->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getDeletedAt());
        $sentReminder->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $sentReminder->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $sentReminder->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertEquals(null, $sentReminder->getUpdatedAt());
        $sentReminder->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $sentReminder->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $sentReminder->getUpdatedAt());
    }

    public function testGetReminder()
    {
        $reminder = new Reminder();
        $sentReminder = new SentReminder();
        $sentReminder->setReminder($reminder);
        $this->assertEquals($reminder, $sentReminder->getReminder());
    }

    public function testSetReminder()
    {
        $reminder = new Reminder();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setReminder($reminder));
        $this->assertEquals($reminder, $sentReminder->getReminder());
    }

    public function testAddReminderMessage()
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

    public function testGetReminderMessages()
    {
        $sentReminder = new SentReminder();
        $this->assertCount(0, $sentReminder->getReminderMessages());
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->addReminderMessage($reminderMessage));
        $this->assertCount(1, $sentReminder->getReminderMessages());
    }

    public function testGetReminderMessagesAll()
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

    public function testRemoveReminderMessage()
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

    public function testGetRoutine()
    {
        $routine = new Routine();
        $sentReminder = new SentReminder();
        $sentReminder->setRoutine($routine);
        $this->assertEquals($routine, $sentReminder->getRoutine());
    }

    public function testSetRoutine()
    {
        $routine = new Routine();
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder->setRoutine($routine));
        $this->assertEquals($routine, $sentReminder->getRoutine());
    }
}
