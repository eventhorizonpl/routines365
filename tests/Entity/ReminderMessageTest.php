<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{AccountOperation, Reminder, ReminderMessage, SentReminder};
use App\Enum\{ReminderMessageThirdPartySystemTypeEnum, ReminderMessageTypeEnum};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
final class ReminderMessageTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setUuid($uuid);
        $this->assertSame($uuid, $reminderMessage->__toString());
    }

    public function testGetId(): void
    {
        $reminderMessage = new ReminderMessage();
        $this->assertNull($reminderMessage->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $reminderMessage = new ReminderMessage();
        $this->assertNull($reminderMessage->getUuid());
        $reminderMessage->setUuid($uuid);
        $this->assertSame($uuid, $reminderMessage->getUuid());
        $this->assertIsString($reminderMessage->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setUuid($uuid));
        $this->assertSame($uuid, $reminderMessage->getUuid());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertNull($reminderMessage->getCreatedAt());
        $reminderMessage->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $reminderMessage->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $reminderMessage->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertNull($reminderMessage->getDeletedAt());
        $reminderMessage->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $reminderMessage->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $reminderMessage->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertNull($reminderMessage->getUpdatedAt());
        $reminderMessage->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $reminderMessage->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $reminderMessage->getUpdatedAt());
    }

    public function testGetAccountOperation(): void
    {
        $accountOperation = new AccountOperation();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setAccountOperation($accountOperation);
        $this->assertSame($accountOperation, $reminderMessage->getAccountOperation());
    }

    public function testSetAccountOperation(): void
    {
        $accountOperation = new AccountOperation();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setAccountOperation($accountOperation));
        $this->assertSame($accountOperation, $reminderMessage->getAccountOperation());
    }

    public function testGetReminder(): void
    {
        $reminder = new Reminder();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setReminder($reminder);
        $this->assertSame($reminder, $reminderMessage->getReminder());
    }

    public function testSetReminder(): void
    {
        $reminder = new Reminder();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setReminder($reminder));
        $this->assertSame($reminder, $reminderMessage->getReminder());
    }

    public function testGetSentReminder(): void
    {
        $sentReminder = new SentReminder();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setSentReminder($sentReminder);
        $this->assertSame($sentReminder, $reminderMessage->getSentReminder());
    }

    public function testSetSentReminder(): void
    {
        $sentReminder = new SentReminder();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setSentReminder($sentReminder));
        $this->assertSame($sentReminder, $reminderMessage->getSentReminder());
    }

    public function testGetContent(): void
    {
        $content = 'test content';
        $reminderMessage = new ReminderMessage();
        $this->assertSame('', $reminderMessage->getContent());
        $reminderMessage->setContent($content);
        $this->assertSame($content, $reminderMessage->getContent());
        $this->assertIsString($reminderMessage->getContent());
    }

    public function testSetContent(): void
    {
        $content = 'test content';
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setContent($content));
        $this->assertSame($content, $reminderMessage->getContent());
    }

    public function testGetIsReadFromBrowser(): void
    {
        $isReadFromBrowser = true;
        $reminderMessage = new ReminderMessage();
        $this->assertFalse($reminderMessage->getIsReadFromBrowser());
        $reminderMessage->setIsReadFromBrowser($isReadFromBrowser);
        $this->assertSame($isReadFromBrowser, $reminderMessage->getIsReadFromBrowser());
        $this->assertIsBool($reminderMessage->getIsReadFromBrowser());
    }

    public function testSetIsReadFromBrowser(): void
    {
        $isReadFromBrowser = true;
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setIsReadFromBrowser($isReadFromBrowser));
        $this->assertSame($isReadFromBrowser, $reminderMessage->getIsReadFromBrowser());
    }

    public function testGetPostDate(): void
    {
        $postDate = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setPostDate($postDate);
        $this->assertSame($postDate, $reminderMessage->getPostDate());
    }

    public function testSetPostDate(): void
    {
        $postDate = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setPostDate($postDate));
        $this->assertSame($postDate, $reminderMessage->getPostDate());
    }

    public function testGetThirdPartySystemResponse(): void
    {
        $thirdPartySystemResponse = 'test third party system response';
        $reminderMessage = new ReminderMessage();
        $this->assertNull($reminderMessage->getThirdPartySystemResponse());
        $reminderMessage->setThirdPartySystemResponse($thirdPartySystemResponse);
        $this->assertSame($thirdPartySystemResponse, $reminderMessage->getThirdPartySystemResponse());
        $this->assertIsString($reminderMessage->getThirdPartySystemResponse());
    }

    public function testSetThirdPartySystemResponse(): void
    {
        $thirdPartySystemResponse = 'test third party system response';
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setThirdPartySystemResponse($thirdPartySystemResponse));
        $this->assertSame($thirdPartySystemResponse, $reminderMessage->getThirdPartySystemResponse());
    }

    public function testGetThirdPartySystemType(): void
    {
        $thirdPartySystemType = ReminderMessageThirdPartySystemTypeEnum::AMAZON_SES;
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setThirdPartySystemType($thirdPartySystemType);
        $this->assertSame($thirdPartySystemType, $reminderMessage->getThirdPartySystemType());
        $this->assertIsString($reminderMessage->getThirdPartySystemType());
    }

    public function testGetThirdPartySystemTypeFormChoices(): void
    {
        $this->assertCount(2, ReminderMessage::getThirdPartySystemTypeFormChoices());
        $this->assertIsArray(ReminderMessage::getThirdPartySystemTypeFormChoices());
    }

    public function testGetThirdPartySystemTypeValidationChoices(): void
    {
        $this->assertCount(2, ReminderMessage::getThirdPartySystemTypeValidationChoices());
        $this->assertIsArray(ReminderMessage::getThirdPartySystemTypeValidationChoices());
    }

    public function testSetThirdPartySystemType(): void
    {
        $thirdPartySystemType = ReminderMessageThirdPartySystemTypeEnum::AMAZON_SES;
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setThirdPartySystemType($thirdPartySystemType));
        $this->assertSame($thirdPartySystemType, $reminderMessage->getThirdPartySystemType());
    }

    public function testSetThirdPartySystemTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $thirdPartySystemType = 'wrong third party system type';
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setThirdPartySystemType($thirdPartySystemType));
    }

    public function testGetType(): void
    {
        $type = ReminderMessageTypeEnum::EMAIL;
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setType($type);
        $this->assertSame($type, $reminderMessage->getType());
        $this->assertIsString($reminderMessage->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(3, ReminderMessage::getTypeFormChoices());
        $this->assertIsArray(ReminderMessage::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(3, ReminderMessage::getTypeValidationChoices());
        $this->assertIsArray(ReminderMessage::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = ReminderMessageTypeEnum::EMAIL;
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setType($type));
        $this->assertSame($type, $reminderMessage->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setType($type));
    }
}
