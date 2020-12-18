<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Account;
use App\Entity\AccountOperation;
use App\Entity\User;
use App\Resource\ConfigResource;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class AccountTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $account = new Account();
        $account->setUuid($uuid);
        $this->assertEquals($uuid, $account->__toString());
    }

    public function testGetId()
    {
        $account = new Account();
        $this->assertEquals(null, $account->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $account = new Account();
        $this->assertEquals(null, $account->getUuid());
        $account->setUuid($uuid);
        $this->assertEquals($uuid, $account->getUuid());
        $this->assertIsString($account->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setUuid($uuid));
        $this->assertEquals($uuid, $account->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertEquals(null, $account->getCreatedBy());
        $account->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $account->getCreatedBy());
        $this->assertIsString($account->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $account->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertEquals(null, $account->getDeletedBy());
        $account->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $account->getDeletedBy());
        $this->assertIsString($account->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $account->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertEquals(null, $account->getUpdatedBy());
        $account->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $account->getUpdatedBy());
        $this->assertIsString($account->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $account->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertEquals(null, $account->getCreatedAt());
        $account->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $account->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $account->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertEquals(null, $account->getDeletedAt());
        $account->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $account->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $account->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertEquals(null, $account->getUpdatedAt());
        $account->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $account->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $account->getUpdatedAt());
    }

    public function testAddAccountOperation()
    {
        $account = new Account();
        $this->assertCount(0, $account->getAccountOperations());
        $accountOperation1 = new AccountOperation();
        $this->assertInstanceOf(Account::class, $account->addAccountOperation($accountOperation1));
        $this->assertCount(1, $account->getAccountOperations());
        $accountOperation2 = new AccountOperation();
        $this->assertInstanceOf(Account::class, $account->addAccountOperation($accountOperation2));
        $this->assertCount(2, $account->getAccountOperations());
        $deletedAt = new DateTimeImmutable();
        $accountOperation2->setDeletedAt($deletedAt);
        $this->assertCount(1, $account->getAccountOperations());
    }

    public function testGetAccountOperations()
    {
        $account = new Account();
        $this->assertCount(0, $account->getAccountOperations());
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(Account::class, $account->addAccountOperation($accountOperation));
        $this->assertCount(1, $account->getAccountOperations());
    }

    public function testGetAccountOperationsAll()
    {
        $account = new Account();
        $this->assertCount(0, $account->getAccountOperationsAll());
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(Account::class, $account->addAccountOperation($accountOperation));
        $this->assertCount(1, $account->getAccountOperationsAll());
        $deletedAt = new DateTimeImmutable();
        $accountOperation->setDeletedAt($deletedAt);
        $this->assertCount(1, $account->getAccountOperationsAll());
    }

    public function testRemoveAccountOperation()
    {
        $account = new Account();
        $this->assertCount(0, $account->getAccountOperations());
        $accountOperation1 = new AccountOperation();
        $this->assertInstanceOf(Account::class, $account->addAccountOperation($accountOperation1));
        $this->assertCount(1, $account->getAccountOperations());
        $accountOperation2 = new AccountOperation();
        $this->assertInstanceOf(Account::class, $account->addAccountOperation($accountOperation2));
        $this->assertCount(2, $account->getAccountOperations());
        $this->assertInstanceOf(Account::class, $account->removeAccountOperation($accountOperation1));
    }

    public function testCanDepositEmailNotifications()
    {
        $emailNotificationsLess = ConfigResource::ACCOUNT_AVAILABLE_EMAIL_NOTIFICATIONS_LIMIT - 10;
        $emailNotificationsMore = ConfigResource::ACCOUNT_AVAILABLE_EMAIL_NOTIFICATIONS_LIMIT + 10;
        $account = new Account();
        $this->assertTrue($account->canDepositEmailNotifications($emailNotificationsLess));
        $this->assertFalse($account->canDepositEmailNotifications($emailNotificationsMore));
    }

    public function testDepositEmailNotifications()
    {
        $emailNotifications = 10;
        $account = new Account();
        $this->assertEquals(0, $account->getAvailableEmailNotifications());
        $this->assertInstanceOf(Account::class, $account->depositEmailNotifications($emailNotifications));
        $this->assertEquals($emailNotifications, $account->getAvailableEmailNotifications());
    }

    public function testGetAvailableEmailNotifications()
    {
        $availableEmailNotifications = 10;
        $account = new Account();
        $this->assertEquals(null, $account->getAvailableEmailNotifications());
        $this->assertIsInt($account->getAvailableEmailNotifications());
        $account->setAvailableEmailNotifications($availableEmailNotifications);
        $this->assertEquals($availableEmailNotifications, $account->getAvailableEmailNotifications());
    }

    public function testSetAvailableEmailNotifications()
    {
        $availableEmailNotifications = 10;
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setAvailableEmailNotifications($availableEmailNotifications));
        $this->assertEquals($availableEmailNotifications, $account->getAvailableEmailNotifications());
    }

    public function testCanWithdrawEmailNotifications()
    {
        $availableEmailNotifications = 10;
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setAvailableEmailNotifications($availableEmailNotifications));
        $this->assertTrue($account->canWithdrawEmailNotifications($availableEmailNotifications));
        $this->assertFalse($account->canWithdrawEmailNotifications($availableEmailNotifications + 1));
    }

    public function testWithdrawEmailNotifications()
    {
        $availableEmailNotifications = 10;
        $account = new Account();
        $this->assertEquals(0, $account->getAvailableEmailNotifications());
        $this->assertInstanceOf(Account::class, $account->setAvailableEmailNotifications($availableEmailNotifications));
        $this->assertEquals($availableEmailNotifications, $account->getAvailableEmailNotifications());
        $this->assertInstanceOf(Account::class, $account->withdrawEmailNotifications($availableEmailNotifications));
        $this->assertEquals(0, $account->getAvailableEmailNotifications());
    }

    public function testCanDepositSmsNotifications()
    {
        $smsNotificationsLess = ConfigResource::ACCOUNT_AVAILABLE_SMS_NOTIFICATIONS_LIMIT - 10;
        $smsNotificationsMore = ConfigResource::ACCOUNT_AVAILABLE_SMS_NOTIFICATIONS_LIMIT + 10;
        $account = new Account();
        $this->assertTrue($account->canDepositSmsNotifications($smsNotificationsLess));
        $this->assertFalse($account->canDepositSmsNotifications($smsNotificationsMore));
    }

    public function testDepositSmsNotifications()
    {
        $smsNotifications = 10;
        $account = new Account();
        $this->assertEquals(0, $account->getAvailableSmsNotifications());
        $this->assertInstanceOf(Account::class, $account->depositSmsNotifications($smsNotifications));
        $this->assertEquals($smsNotifications, $account->getAvailableSmsNotifications());
    }

    public function testGetAvailableSmsNotifications()
    {
        $availableSmsNotifications = 10;
        $account = new Account();
        $this->assertEquals(null, $account->getAvailableSmsNotifications());
        $this->assertIsInt($account->getAvailableSmsNotifications());
        $account->setAvailableSmsNotifications($availableSmsNotifications);
        $this->assertEquals($availableSmsNotifications, $account->getAvailableSmsNotifications());
    }

    public function testSetAvailableSmsNotifications()
    {
        $availableSmsNotifications = 10;
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setAvailableSmsNotifications($availableSmsNotifications));
        $this->assertEquals($availableSmsNotifications, $account->getAvailableSmsNotifications());
    }

    public function testCanWithdrawSmsNotifications()
    {
        $availableSmsNotifications = 10;
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setAvailableSmsNotifications($availableSmsNotifications));
        $this->assertTrue($account->canWithdrawSmsNotifications($availableSmsNotifications));
        $this->assertFalse($account->canWithdrawSmsNotifications($availableSmsNotifications + 1));
    }

    public function testWithdrawSmsNotifications()
    {
        $availableSmsNotifications = 10;
        $account = new Account();
        $this->assertEquals(0, $account->getAvailableSmsNotifications());
        $this->assertInstanceOf(Account::class, $account->setAvailableSmsNotifications($availableSmsNotifications));
        $this->assertEquals($availableSmsNotifications, $account->getAvailableSmsNotifications());
        $this->assertInstanceOf(Account::class, $account->withdrawSmsNotifications($availableSmsNotifications));
        $this->assertEquals(0, $account->getAvailableSmsNotifications());
    }

    public function testGetUser()
    {
        $user = new User();
        $account = new Account();
        $account->setUser($user);
        $this->assertEquals($user, $account->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setUser($user));
        $this->assertEquals($user, $account->getUser());
    }
}
