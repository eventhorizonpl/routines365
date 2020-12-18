<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\AccountOperation;
use App\Entity\Reminder;
use App\Entity\ReminderMessage;
use App\Entity\SentReminder;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class ReminderMessageTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setUuid($uuid);
        $this->assertEquals($uuid, $reminderMessage->__toString());
    }

    public function testGetId()
    {
        $reminderMessage = new ReminderMessage();
        $this->assertEquals(null, $reminderMessage->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $reminderMessage = new ReminderMessage();
        $this->assertEquals(null, $reminderMessage->getUuid());
        $reminderMessage->setUuid($uuid);
        $this->assertEquals($uuid, $reminderMessage->getUuid());
        $this->assertIsString($reminderMessage->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setUuid($uuid));
        $this->assertEquals($uuid, $reminderMessage->getUuid());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertEquals(null, $reminderMessage->getCreatedAt());
        $reminderMessage->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $reminderMessage->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $reminderMessage->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertEquals(null, $reminderMessage->getDeletedAt());
        $reminderMessage->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $reminderMessage->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $reminderMessage->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertEquals(null, $reminderMessage->getUpdatedAt());
        $reminderMessage->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $reminderMessage->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $reminderMessage->getUpdatedAt());
    }

    public function testGetAccountOperation()
    {
        $accountOperation = new AccountOperation();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setAccountOperation($accountOperation);
        $this->assertEquals($accountOperation, $reminderMessage->getAccountOperation());
    }

    public function testSetAccountOperation()
    {
        $accountOperation = new AccountOperation();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setAccountOperation($accountOperation));
        $this->assertEquals($accountOperation, $reminderMessage->getAccountOperation());
    }

    public function testGetReminder()
    {
        $reminder = new Reminder();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setReminder($reminder);
        $this->assertEquals($reminder, $reminderMessage->getReminder());
    }

    public function testSetReminder()
    {
        $reminder = new Reminder();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setReminder($reminder));
        $this->assertEquals($reminder, $reminderMessage->getReminder());
    }

    public function testGetSentReminder()
    {
        $sentReminder = new SentReminder();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setSentReminder($sentReminder);
        $this->assertEquals($sentReminder, $reminderMessage->getSentReminder());
    }

    public function testSetSentReminder()
    {
        $sentReminder = new SentReminder();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setSentReminder($sentReminder));
        $this->assertEquals($sentReminder, $reminderMessage->getSentReminder());
    }

    public function testGetContent()
    {
        $content = 'test content';
        $reminderMessage = new ReminderMessage();
        $this->assertEquals(null, $reminderMessage->getContent());
        $reminderMessage->setContent($content);
        $this->assertEquals($content, $reminderMessage->getContent());
        $this->assertIsString($reminderMessage->getContent());
    }

    public function testSetContent()
    {
        $content = 'test content';
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setContent($content));
        $this->assertEquals($content, $reminderMessage->getContent());
    }

    public function testGetPostDate()
    {
        $postDate = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setPostDate($postDate);
        $this->assertEquals($postDate, $reminderMessage->getPostDate());
    }

    public function testSetPostDate()
    {
        $postDate = new DateTimeImmutable();
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setPostDate($postDate));
        $this->assertEquals($postDate, $reminderMessage->getPostDate());
    }

    public function testGetThirdPartySystemResponse()
    {
        $thirdPartySystemResponse = 'test third party system response';
        $reminderMessage = new ReminderMessage();
        $this->assertEquals(null, $reminderMessage->getThirdPartySystemResponse());
        $reminderMessage->setThirdPartySystemResponse($thirdPartySystemResponse);
        $this->assertEquals($thirdPartySystemResponse, $reminderMessage->getThirdPartySystemResponse());
        $this->assertIsString($reminderMessage->getThirdPartySystemResponse());
    }

    public function testSetThirdPartySystemResponse()
    {
        $thirdPartySystemResponse = 'test third party system response';
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setThirdPartySystemResponse($thirdPartySystemResponse));
        $this->assertEquals($thirdPartySystemResponse, $reminderMessage->getThirdPartySystemResponse());
    }

    public function testGetThirdPartySystemType()
    {
        $thirdPartySystemType = ReminderMessage::THIRD_PARTY_SYSTEM_TYPE_AMAZON_SES;
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setThirdPartySystemType($thirdPartySystemType);
        $this->assertEquals($thirdPartySystemType, $reminderMessage->getThirdPartySystemType());
        $this->assertIsString($reminderMessage->getThirdPartySystemType());
    }

    public function testGetThirdPartySystemTypeFormChoices()
    {
        $this->assertCount(2, ReminderMessage::getThirdPartySystemTypeFormChoices());
        $this->assertIsArray(ReminderMessage::getThirdPartySystemTypeFormChoices());
    }

    public function testGetThirdPartySystemTypeValidationChoices()
    {
        $this->assertCount(2, ReminderMessage::getThirdPartySystemTypeValidationChoices());
        $this->assertIsArray(ReminderMessage::getThirdPartySystemTypeValidationChoices());
    }

    public function testSetThirdPartySystemType()
    {
        $thirdPartySystemType = ReminderMessage::THIRD_PARTY_SYSTEM_TYPE_AMAZON_SES;
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setThirdPartySystemType($thirdPartySystemType));
        $this->assertEquals($thirdPartySystemType, $reminderMessage->getThirdPartySystemType());
    }

    public function testGetType()
    {
        $type = ReminderMessage::TYPE_EMAIL;
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setType($type);
        $this->assertEquals($type, $reminderMessage->getType());
        $this->assertIsString($reminderMessage->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(2, ReminderMessage::getTypeFormChoices());
        $this->assertIsArray(ReminderMessage::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(2, ReminderMessage::getTypeValidationChoices());
        $this->assertIsArray(ReminderMessage::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = ReminderMessage::TYPE_EMAIL;
        $reminderMessage = new ReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage->setType($type));
        $this->assertEquals($type, $reminderMessage->getType());
    }
}
