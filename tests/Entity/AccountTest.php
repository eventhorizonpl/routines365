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
    public function testConstruct(): void
    {
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $account = new Account();
        $account->setUuid($uuid);
        $this->assertEquals($uuid, $account->__toString());
    }

    public function testGetId(): void
    {
        $account = new Account();
        $this->assertEquals(null, $account->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $account = new Account();
        $this->assertEquals(null, $account->getUuid());
        $account->setUuid($uuid);
        $this->assertEquals($uuid, $account->getUuid());
        $this->assertIsString($account->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setUuid($uuid));
        $this->assertEquals($uuid, $account->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertEquals(null, $account->getCreatedBy());
        $account->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $account->getCreatedBy());
        $this->assertIsString($account->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $account->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertEquals(null, $account->getDeletedBy());
        $account->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $account->getDeletedBy());
        $this->assertIsString($account->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $account->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertEquals(null, $account->getUpdatedBy());
        $account->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $account->getUpdatedBy());
        $this->assertIsString($account->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $account->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertEquals(null, $account->getCreatedAt());
        $account->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $account->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $account->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertEquals(null, $account->getDeletedAt());
        $account->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $account->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $account->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertEquals(null, $account->getUpdatedAt());
        $account->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $account->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $account->getUpdatedAt());
    }

    public function testAddAccountOperation(): void
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

    public function testGetAccountOperations(): void
    {
        $account = new Account();
        $this->assertCount(0, $account->getAccountOperations());
        $accountOperation = new AccountOperation();
        $this->assertInstanceOf(Account::class, $account->addAccountOperation($accountOperation));
        $this->assertCount(1, $account->getAccountOperations());
    }

    public function testGetAccountOperationsAll(): void
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

    public function testRemoveAccountOperation(): void
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

    public function testCanDepositNotifications(): void
    {
        $notificationsLess = ConfigResource::ACCOUNT_AVAILABLE_NOTIFICATIONS_LIMIT - 10;
        $notificationsMore = ConfigResource::ACCOUNT_AVAILABLE_NOTIFICATIONS_LIMIT + 10;
        $account = new Account();
        $this->assertTrue($account->canDepositNotifications($notificationsLess));
        $this->assertFalse($account->canDepositNotifications($notificationsMore));
    }

    public function testDepositNotifications(): void
    {
        $notifications = 10;
        $account = new Account();
        $this->assertEquals(0, $account->getAvailableNotifications());
        $this->assertInstanceOf(Account::class, $account->depositNotifications($notifications));
        $this->assertEquals($notifications, $account->getAvailableNotifications());
    }

    public function testGetAvailableNotifications(): void
    {
        $availableNotifications = 10;
        $account = new Account();
        $this->assertEquals(null, $account->getAvailableNotifications());
        $this->assertIsInt($account->getAvailableNotifications());
        $account->setAvailableNotifications($availableNotifications);
        $this->assertEquals($availableNotifications, $account->getAvailableNotifications());
    }

    public function testSetAvailableNotifications(): void
    {
        $availableNotifications = 10;
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setAvailableNotifications($availableNotifications));
        $this->assertEquals($availableNotifications, $account->getAvailableNotifications());
    }

    public function testCanWithdrawNotifications(): void
    {
        $availableNotifications = 10;
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setAvailableNotifications($availableNotifications));
        $this->assertTrue($account->canWithdrawNotifications($availableNotifications));
        $this->assertFalse($account->canWithdrawNotifications($availableNotifications + 1));
    }

    public function testWithdrawNotifications(): void
    {
        $availableNotifications = 10;
        $account = new Account();
        $this->assertEquals(0, $account->getAvailableNotifications());
        $this->assertInstanceOf(Account::class, $account->setAvailableNotifications($availableNotifications));
        $this->assertEquals($availableNotifications, $account->getAvailableNotifications());
        $this->assertInstanceOf(Account::class, $account->withdrawNotifications($availableNotifications));
        $this->assertEquals(0, $account->getAvailableNotifications());
    }

    public function testCanDepositSmsNotifications(): void
    {
        $smsNotificationsLess = ConfigResource::ACCOUNT_AVAILABLE_SMS_NOTIFICATIONS_LIMIT - 10;
        $smsNotificationsMore = ConfigResource::ACCOUNT_AVAILABLE_SMS_NOTIFICATIONS_LIMIT + 10;
        $account = new Account();
        $this->assertTrue($account->canDepositSmsNotifications($smsNotificationsLess));
        $this->assertFalse($account->canDepositSmsNotifications($smsNotificationsMore));
    }

    public function testDepositSmsNotifications(): void
    {
        $smsNotifications = 10;
        $account = new Account();
        $this->assertEquals(0, $account->getAvailableSmsNotifications());
        $this->assertInstanceOf(Account::class, $account->depositSmsNotifications($smsNotifications));
        $this->assertEquals($smsNotifications, $account->getAvailableSmsNotifications());
    }

    public function testGetAvailableSmsNotifications(): void
    {
        $availableSmsNotifications = 10;
        $account = new Account();
        $this->assertEquals(null, $account->getAvailableSmsNotifications());
        $this->assertIsInt($account->getAvailableSmsNotifications());
        $account->setAvailableSmsNotifications($availableSmsNotifications);
        $this->assertEquals($availableSmsNotifications, $account->getAvailableSmsNotifications());
    }

    public function testSetAvailableSmsNotifications(): void
    {
        $availableSmsNotifications = 10;
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setAvailableSmsNotifications($availableSmsNotifications));
        $this->assertEquals($availableSmsNotifications, $account->getAvailableSmsNotifications());
    }

    public function testCanWithdrawSmsNotifications(): void
    {
        $availableSmsNotifications = 10;
        $account = new Account();
        $this->assertInstanceOf(Account::class, $account->setAvailableSmsNotifications($availableSmsNotifications));
        $this->assertTrue($account->canWithdrawSmsNotifications($availableSmsNotifications));
        $this->assertFalse($account->canWithdrawSmsNotifications($availableSmsNotifications + 1));
    }

    public function testWithdrawSmsNotifications(): void
    {
        $availableSmsNotifications = 10;
        $account = new Account();
        $this->assertEquals(0, $account->getAvailableSmsNotifications());
        $this->assertInstanceOf(Account::class, $account->setAvailableSmsNotifications($availableSmsNotifications));
        $this->assertEquals($availableSmsNotifications, $account->getAvailableSmsNotifications());
        $this->assertInstanceOf(Account::class, $account->withdrawSmsNotifications($availableSmsNotifications));
        $this->assertEquals(0, $account->getAvailableSmsNotifications());
    }

    public function testAddUser(): void
    {
        $account = new Account();
        $this->assertCount(0, $account->getUsers());
        $user1 = new User();
        $this->assertInstanceOf(Account::class, $account->addUser($user1));
        $this->assertCount(1, $account->getUsers());
        $user2 = new User();
        $this->assertInstanceOf(Account::class, $account->addUser($user2));
        $this->assertCount(2, $account->getUsers());
    }

    public function testGetUsers(): void
    {
        $account = new Account();
        $this->assertCount(0, $account->getUsers());
        $user = new User();
        $this->assertInstanceOf(Account::class, $account->addUser($user));
        $this->assertCount(1, $account->getUsers());
    }

    public function testRemoveUser(): void
    {
        $account = new Account();
        $this->assertCount(0, $account->getUsers());
        $user1 = new User();
        $this->assertInstanceOf(Account::class, $account->addUser($user1));
        $this->assertCount(1, $account->getUsers());
        $user2 = new User();
        $this->assertInstanceOf(Account::class, $account->addUser($user2));
        $this->assertCount(2, $account->getUsers());
        $this->assertInstanceOf(Account::class, $account->removeUser($user1));
    }
}
