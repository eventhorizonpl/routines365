<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{Reminder, ReminderMessage, Routine, SentReminder, User};
use App\Enum\ReminderTypeEnum;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
final class ReminderTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $reminder = new Reminder();
        $reminder->setUuid($uuid);
        $this->assertSame($uuid, $reminder->__toString());
    }

    public function testGetId(): void
    {
        $reminder = new Reminder();
        $this->assertNull($reminder->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $reminder = new Reminder();
        $this->assertNull($reminder->getUuid());
        $reminder->setUuid($uuid);
        $this->assertSame($uuid, $reminder->getUuid());
        $this->assertIsString($reminder->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setUuid($uuid));
        $this->assertSame($uuid, $reminder->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $reminder = new Reminder();
        $this->assertNull($reminder->getCreatedBy());
        $reminder->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $reminder->getCreatedBy());
        $this->assertIsString($reminder->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $reminder->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $reminder = new Reminder();
        $this->assertNull($reminder->getDeletedBy());
        $reminder->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $reminder->getDeletedBy());
        $this->assertIsString($reminder->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $reminder->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $reminder = new Reminder();
        $this->assertNull($reminder->getUpdatedBy());
        $reminder->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $reminder->getUpdatedBy());
        $this->assertIsString($reminder->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $reminder->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertNull($reminder->getCreatedAt());
        $reminder->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $reminder->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $reminder->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertNull($reminder->getDeletedAt());
        $reminder->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $reminder->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $reminder->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertNull($reminder->getUpdatedAt());
        $reminder->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $reminder->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $reminder->getUpdatedAt());
    }

    public function testGetLockedAt(): void
    {
        $lockedAt = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertNull($reminder->getLockedAt());
        $reminder->setLockedAt($lockedAt);
        $this->assertSame($lockedAt, $reminder->getLockedAt());
    }

    public function testSetLockedAt(): void
    {
        $lockedAt = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setLockedAt($lockedAt));
        $this->assertSame($lockedAt, $reminder->getLockedAt());
    }

    public function testGetIsEnabled(): void
    {
        $isEnabled = true;
        $reminder = new Reminder();
        $this->assertTrue($reminder->getIsEnabled());
        $reminder->setIsEnabled($isEnabled);
        $this->assertSame($isEnabled, $reminder->getIsEnabled());
        $this->assertIsBool($reminder->getIsEnabled());
    }

    public function testSetIsEnabled(): void
    {
        $isEnabled = true;
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setIsEnabled($isEnabled));
        $this->assertSame($isEnabled, $reminder->getIsEnabled());
    }

    public function testGetRoutine(): void
    {
        $routine = new Routine();
        $reminder = new Reminder();
        $reminder->setRoutine($routine);
        $this->assertSame($routine, $reminder->getRoutine());
    }

    public function testSetRoutine(): void
    {
        $routine = new Routine();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setRoutine($routine));
        $this->assertSame($routine, $reminder->getRoutine());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $reminder = new Reminder();
        $reminder->setUser($user);
        $this->assertSame($user, $reminder->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setUser($user));
        $this->assertSame($user, $reminder->getUser());
    }

    public function testGetHour(): void
    {
        $hour = new DateTimeImmutable();
        $reminder = new Reminder();
        $reminder->setHour($hour);
        $this->assertSame($hour, $reminder->getHour());
    }

    public function testSetHour(): void
    {
        $hour = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setHour($hour));
        $this->assertSame($hour, $reminder->getHour());
    }

    public function testGetMinutesBefore(): void
    {
        $minutesBefore = 10;
        $reminder = new Reminder();
        $reminder->setMinutesBefore($minutesBefore);
        $this->assertSame($minutesBefore, $reminder->getMinutesBefore());
        $this->assertIsInt($reminder->getMinutesBefore());
    }

    public function testGetMinutesBeforeFormChoices(): void
    {
        $this->assertCount(6, Reminder::getMinutesBeforeFormChoices());
        $this->assertIsArray(Reminder::getMinutesBeforeFormChoices());
    }

    public function testGetMinutesBeforeValidationChoices(): void
    {
        $this->assertCount(6, Reminder::getMinutesBeforeValidationChoices());
        $this->assertIsArray(Reminder::getMinutesBeforeValidationChoices());
    }

    public function testSetMinutesBefore(): void
    {
        $minutesBefore = 10;
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setMinutesBefore($minutesBefore));
        $this->assertSame($minutesBefore, $reminder->getMinutesBefore());
    }

    public function testGetNextDate(): void
    {
        $nextDate = new DateTimeImmutable();
        $reminder = new Reminder();
        $reminder->setNextDate($nextDate);
        $this->assertSame($nextDate, $reminder->getNextDate());
    }

    public function testSetNextDate(): void
    {
        $nextDate = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setNextDate($nextDate));
        $this->assertSame($nextDate, $reminder->getNextDate());
    }

    public function testGetNextDateLocalTime(): void
    {
        $nextDateLocalTime = new DateTimeImmutable();
        $reminder = new Reminder();
        $reminder->setNextDateLocalTime($nextDateLocalTime);
        $this->assertSame($nextDateLocalTime, $reminder->getNextDateLocalTime());
    }

    public function testSetNextDateLocalTime(): void
    {
        $nextDateLocalTime = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setNextDateLocalTime($nextDateLocalTime));
        $this->assertSame($nextDateLocalTime, $reminder->getNextDateLocalTime());
    }

    public function testGetPreviousDate(): void
    {
        $previousDate = new DateTimeImmutable();
        $reminder = new Reminder();
        $reminder->setPreviousDate($previousDate);
        $this->assertSame($previousDate, $reminder->getPreviousDate());
    }

    public function testSetPreviousDate(): void
    {
        $previousDate = new DateTimeImmutable();
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setPreviousDate($previousDate));
        $this->assertSame($previousDate, $reminder->getPreviousDate());
    }

    public function testAddReminderMessage(): void
    {
        $reminder = new Reminder();
        $this->assertCount(0, $reminder->getReminderMessages());
        $reminderMessage1 = new ReminderMessage();
        $this->assertInstanceOf(Reminder::class, $reminder->addReminderMessage($reminderMessage1));
        $this->assertCount(1, $reminder->getReminderMessages());
        $reminderMessage2 = new ReminderMessage();
        $this->assertInstanceOf(Reminder::class, $reminder->addReminderMessage($reminderMessage2));
        $this->assertCount(2, $reminder->getReminderMessages());
        $deletedAt = new DateTimeImmutable();
        $reminderMessage2->setDeletedAt($deletedAt);
        $this->assertCount(1, $reminder->getReminderMessages());
    }

    public function testGetReminderMessages(): void
    {
        $reminder = new Reminder();
        $this->assertCount(0, $reminder->getReminderMessages());
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(Reminder::class, $reminder->addReminderMessage($reminderMessage));
        $this->assertCount(1, $reminder->getReminderMessages());
    }

    public function testGetReminderMessagesAll(): void
    {
        $reminder = new Reminder();
        $this->assertCount(0, $reminder->getReminderMessagesAll());
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(Reminder::class, $reminder->addReminderMessage($reminderMessage));
        $this->assertCount(1, $reminder->getReminderMessagesAll());
        $deletedAt = new DateTimeImmutable();
        $reminderMessage->setDeletedAt($deletedAt);
        $this->assertCount(1, $reminder->getReminderMessagesAll());
    }

    public function testRemoveReminderMessage(): void
    {
        $reminder = new Reminder();
        $this->assertCount(0, $reminder->getReminderMessages());
        $reminderMessage1 = new ReminderMessage();
        $this->assertInstanceOf(Reminder::class, $reminder->addReminderMessage($reminderMessage1));
        $this->assertCount(1, $reminder->getReminderMessages());
        $reminderMessage2 = new ReminderMessage();
        $this->assertInstanceOf(Reminder::class, $reminder->addReminderMessage($reminderMessage2));
        $this->assertCount(2, $reminder->getReminderMessages());
        $this->assertInstanceOf(Reminder::class, $reminder->removeReminderMessage($reminderMessage1));
    }

    public function testGetRoutineStartDate(): void
    {
        $nextDate = new DateTimeImmutable();
        $reminder = new Reminder();
        $reminder->setMinutesBefore(0);
        $this->assertInstanceOf(Reminder::class, $reminder->setNextDate($nextDate));
        $this->assertInstanceOf(DateTimeImmutable::class, $reminder->getRoutineStartDate());
    }

    public function testGetRoutineStartDateLocalTime(): void
    {
        $nextDateLocalTime = new DateTimeImmutable();
        $reminder = new Reminder();
        $reminder->setMinutesBefore(0);
        $this->assertInstanceOf(Reminder::class, $reminder->setNextDateLocalTime($nextDateLocalTime));
        $this->assertInstanceOf(DateTimeImmutable::class, $reminder->getNextDateLocalTime());
    }

    public function testGetSendEmail(): void
    {
        $sendEmail = true;
        $reminder = new Reminder();
        $this->assertTrue($reminder->getSendEmail());
        $reminder->setSendEmail($sendEmail);
        $this->assertSame($sendEmail, $reminder->getSendEmail());
        $this->assertIsBool($reminder->getSendEmail());
    }

    public function testSetSendEmail(): void
    {
        $sendEmail = true;
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setSendEmail($sendEmail));
        $this->assertSame($sendEmail, $reminder->getSendEmail());
    }

    public function testGetSendToBrowser(): void
    {
        $sendToBrowser = true;
        $reminder = new Reminder();
        $this->assertFalse($reminder->getSendToBrowser());
        $reminder->setSendToBrowser($sendToBrowser);
        $this->assertSame($sendToBrowser, $reminder->getSendToBrowser());
        $this->assertIsBool($reminder->getSendToBrowser());
    }

    public function testSetSendToBrowser(): void
    {
        $sendToBrowser = true;
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setSendToBrowser($sendToBrowser));
        $this->assertSame($sendToBrowser, $reminder->getSendToBrowser());
    }

    public function testGetSendMotivationalMessage(): void
    {
        $sendMotivationalMessage = true;
        $reminder = new Reminder();
        $reminder->setSendMotivationalMessage($sendMotivationalMessage);
        $this->assertSame($sendMotivationalMessage, $reminder->getSendMotivationalMessage());
        $this->assertIsBool($reminder->getSendMotivationalMessage());
    }

    public function testSetSendMotivationalMessage(): void
    {
        $sendMotivationalMessage = true;
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setSendMotivationalMessage($sendMotivationalMessage));
        $this->assertSame($sendMotivationalMessage, $reminder->getSendMotivationalMessage());
    }

    public function testGetSendSms(): void
    {
        $sendSms = true;
        $reminder = new Reminder();
        $reminder->setSendSms($sendSms);
        $this->assertSame($sendSms, $reminder->getSendSms());
        $this->assertIsBool($reminder->getSendSms());
    }

    public function testSetSendSms(): void
    {
        $sendSms = true;
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setSendSms($sendSms));
        $this->assertSame($sendSms, $reminder->getSendSms());
    }

    public function testAddSentReminder(): void
    {
        $reminder = new Reminder();
        $this->assertCount(0, $reminder->getSentReminders());
        $sentReminder1 = new SentReminder();
        $this->assertInstanceOf(Reminder::class, $reminder->addSentReminder($sentReminder1));
        $this->assertCount(1, $reminder->getSentReminders());
        $sentReminder2 = new SentReminder();
        $this->assertInstanceOf(Reminder::class, $reminder->addSentReminder($sentReminder2));
        $this->assertCount(2, $reminder->getSentReminders());
        $deletedAt = new DateTimeImmutable();
        $sentReminder2->setDeletedAt($deletedAt);
        $this->assertCount(1, $reminder->getSentReminders());
    }

    public function testGetSentReminders(): void
    {
        $reminder = new Reminder();
        $this->assertCount(0, $reminder->getSentReminders());
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(Reminder::class, $reminder->addSentReminder($sentReminder));
        $this->assertCount(1, $reminder->getSentReminders());
    }

    public function testGetSentRemindersAll(): void
    {
        $reminder = new Reminder();
        $this->assertCount(0, $reminder->getSentRemindersAll());
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(Reminder::class, $reminder->addSentReminder($sentReminder));
        $this->assertCount(1, $reminder->getSentRemindersAll());
        $deletedAt = new DateTimeImmutable();
        $sentReminder->setDeletedAt($deletedAt);
        $this->assertCount(1, $reminder->getSentRemindersAll());
    }

    public function testRemoveSentReminder(): void
    {
        $reminder = new Reminder();
        $this->assertCount(0, $reminder->getSentReminders());
        $sentReminder1 = new SentReminder();
        $this->assertInstanceOf(Reminder::class, $reminder->addSentReminder($sentReminder1));
        $this->assertCount(1, $reminder->getSentReminders());
        $sentReminder2 = new SentReminder();
        $this->assertInstanceOf(Reminder::class, $reminder->addSentReminder($sentReminder2));
        $this->assertCount(2, $reminder->getSentReminders());
        $this->assertInstanceOf(Reminder::class, $reminder->removeSentReminder($sentReminder1));
    }

    public function testGetType(): void
    {
        $type = ReminderTypeEnum::DAILY;
        $reminder = new Reminder();
        $reminder->setType($type);
        $this->assertSame($type, $reminder->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(8, Reminder::getTypeFormChoices());
        $this->assertIsArray(Reminder::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(8, Reminder::getTypeValidationChoices());
        $this->assertIsArray(Reminder::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = ReminderTypeEnum::DAILY;
        $reminder = new Reminder();
        $this->assertInstanceOf(Reminder::class, $reminder->setType($type));
        $this->assertSame($type, $reminder->getType());
    }
}
