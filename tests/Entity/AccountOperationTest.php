<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Account;
use App\Entity\AccountOperation;
use App\Entity\ReminderMessage;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final class AccountOperationTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $accountOperation->setUuid($uuid);
        $this->assertEquals($uuid, $accountOperation->__toString());
    }

    public function testGetId()
    {
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getUuid());
        $accountOperation->setUuid($uuid);
        $this->assertEquals($uuid, $accountOperation->getUuid());
        $this->assertIsString($accountOperation->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setUuid($uuid));
        $this->assertEquals($uuid, $accountOperation->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getCreatedBy());
        $accountOperation->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $accountOperation->getCreatedBy());
        $this->assertIsString($accountOperation->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $accountOperation->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getDeletedBy());
        $accountOperation->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $accountOperation->getDeletedBy());
        $this->assertIsString($accountOperation->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $accountOperation->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getUpdatedBy());
        $accountOperation->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $accountOperation->getUpdatedBy());
        $this->assertIsString($accountOperation->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $accountOperation->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getCreatedAt());
        $accountOperation->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $accountOperation->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $accountOperation->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getDeletedAt());
        $accountOperation->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $accountOperation->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $accountOperation->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getUpdatedAt());
        $accountOperation->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $accountOperation->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $accountOperation->getUpdatedAt());
    }

    public function testGetAccount()
    {
        $account = new Account();
        $accountOperation = new AccountOperation();
        $accountOperation->setAccount($account);
        $this->assertEquals($account, $accountOperation->getAccount());
    }

    public function testSetAccount()
    {
        $account = new Account();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setAccount($account));
        $this->assertEquals($account, $accountOperation->getAccount());
    }

    public function testGetReminderMessage()
    {
        $reminderMessage = new ReminderMessage();
        $accountOperation = new AccountOperation();
        $accountOperation->setReminderMessage($reminderMessage);
        $this->assertEquals($reminderMessage, $accountOperation->getReminderMessage());
    }

    public function testSetReminderMessage()
    {
        $reminderMessage = new ReminderMessage();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setReminderMessage($reminderMessage));
        $this->assertEquals($reminderMessage, $accountOperation->getReminderMessage());
    }

    public function testGetDescription()
    {
        $description = 'test description';
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getDescription());
        $accountOperation->setDescription($description);
        $this->assertEquals($description, $accountOperation->getDescription());
        $this->assertIsString($accountOperation->getDescription());
    }

    public function testSetDescription()
    {
        $description = 'test description';
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setDescription($description));
        $this->assertEquals($description, $accountOperation->getDescription());
    }

    public function testGetEmailNotifications()
    {
        $emailNotifications = 10;
        $accountOperation = new AccountOperation();
        $this->assertEquals(0, $accountOperation->getEmailNotifications());
        $accountOperation->setEmailNotifications($emailNotifications);
        $this->assertEquals($emailNotifications, $accountOperation->getEmailNotifications());
        $this->assertIsInt($accountOperation->getEmailNotifications());
    }

    public function testSetEmailNotifications()
    {
        $emailNotifications = 10;
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setEmailNotifications($emailNotifications));
        $this->assertEquals($emailNotifications, $accountOperation->getEmailNotifications());
    }

    public function testGetSmsNotifications()
    {
        $smsNotifications = 10;
        $accountOperation = new AccountOperation();
        $this->assertEquals(0, $accountOperation->getSmsNotifications());
        $accountOperation->setSmsNotifications($smsNotifications);
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertIsInt($accountOperation->getSmsNotifications());
    }

    public function testSetSmsNotifications()
    {
        $smsNotifications = 10;
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setSmsNotifications($smsNotifications));
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
    }

    public function testGetType()
    {
        $type = AccountOperation::TYPE_DEPOSIT;
        $accountOperation = new AccountOperation();
        $accountOperation->setType($type);
        $this->assertEquals($type, $accountOperation->getType());
        $this->assertIsString($accountOperation->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(2, AccountOperation::getTypeFormChoices());
        $this->assertIsArray(AccountOperation::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(2, AccountOperation::getTypeValidationChoices());
        $this->assertIsArray(AccountOperation::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = AccountOperation::TYPE_DEPOSIT;
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setType($type));
        $this->assertEquals($type, $accountOperation->getType());
    }

    public function testSetTypeException()
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setType($type));
    }
}
