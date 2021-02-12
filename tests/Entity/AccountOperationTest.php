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
    public function testConstruct(): void
    {
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $accountOperation->setUuid($uuid);
        $this->assertEquals($uuid, $accountOperation->__toString());
    }

    public function testGetId(): void
    {
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getUuid());
        $accountOperation->setUuid($uuid);
        $this->assertEquals($uuid, $accountOperation->getUuid());
        $this->assertIsString($accountOperation->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setUuid($uuid));
        $this->assertEquals($uuid, $accountOperation->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getCreatedBy());
        $accountOperation->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $accountOperation->getCreatedBy());
        $this->assertIsString($accountOperation->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $accountOperation->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getDeletedBy());
        $accountOperation->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $accountOperation->getDeletedBy());
        $this->assertIsString($accountOperation->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $accountOperation->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getUpdatedBy());
        $accountOperation->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $accountOperation->getUpdatedBy());
        $this->assertIsString($accountOperation->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $accountOperation->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getCreatedAt());
        $accountOperation->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $accountOperation->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $accountOperation->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getDeletedAt());
        $accountOperation->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $accountOperation->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $accountOperation->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getUpdatedAt());
        $accountOperation->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $accountOperation->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $accountOperation->getUpdatedAt());
    }

    public function testGetAccount(): void
    {
        $account = new Account();
        $accountOperation = new AccountOperation();
        $accountOperation->setAccount($account);
        $this->assertEquals($account, $accountOperation->getAccount());
    }

    public function testSetAccount(): void
    {
        $account = new Account();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setAccount($account));
        $this->assertEquals($account, $accountOperation->getAccount());
    }

    public function testGetReminderMessage(): void
    {
        $reminderMessage = new ReminderMessage();
        $accountOperation = new AccountOperation();
        $accountOperation->setReminderMessage($reminderMessage);
        $this->assertEquals($reminderMessage, $accountOperation->getReminderMessage());
    }

    public function testSetReminderMessage(): void
    {
        $reminderMessage = new ReminderMessage();
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setReminderMessage($reminderMessage));
        $this->assertEquals($reminderMessage, $accountOperation->getReminderMessage());
    }

    public function testGetDescription(): void
    {
        $description = 'test description';
        $accountOperation = new AccountOperation();
        $this->assertEquals(null, $accountOperation->getDescription());
        $accountOperation->setDescription($description);
        $this->assertEquals($description, $accountOperation->getDescription());
        $this->assertIsString($accountOperation->getDescription());
    }

    public function testSetDescription(): void
    {
        $description = 'test description';
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setDescription($description));
        $this->assertEquals($description, $accountOperation->getDescription());
    }

    public function testGetNotifications(): void
    {
        $notifications = 10;
        $accountOperation = new AccountOperation();
        $this->assertEquals(0, $accountOperation->getNotifications());
        $accountOperation->setNotifications($notifications);
        $this->assertEquals($notifications, $accountOperation->getNotifications());
        $this->assertIsInt($accountOperation->getNotifications());
    }

    public function testSetNotifications(): void
    {
        $notifications = 10;
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setNotifications($notifications));
        $this->assertEquals($notifications, $accountOperation->getNotifications());
    }

    public function testGetSmsNotifications(): void
    {
        $smsNotifications = 10;
        $accountOperation = new AccountOperation();
        $this->assertEquals(0, $accountOperation->getSmsNotifications());
        $accountOperation->setSmsNotifications($smsNotifications);
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
        $this->assertIsInt($accountOperation->getSmsNotifications());
    }

    public function testSetSmsNotifications(): void
    {
        $smsNotifications = 10;
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setSmsNotifications($smsNotifications));
        $this->assertEquals($smsNotifications, $accountOperation->getSmsNotifications());
    }

    public function testGetType(): void
    {
        $type = AccountOperation::TYPE_DEPOSIT;
        $accountOperation = new AccountOperation();
        $accountOperation->setType($type);
        $this->assertEquals($type, $accountOperation->getType());
        $this->assertIsString($accountOperation->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(2, AccountOperation::getTypeFormChoices());
        $this->assertIsArray(AccountOperation::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(2, AccountOperation::getTypeValidationChoices());
        $this->assertIsArray(AccountOperation::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = AccountOperation::TYPE_DEPOSIT;
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setType($type));
        $this->assertEquals($type, $accountOperation->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(AccountOperation::class, $accountOperation->setType($type));
    }
}
