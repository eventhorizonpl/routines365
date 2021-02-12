<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Promotion;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final class PromotionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion);
    }

    public function testToString(): void
    {
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $promotion = new Promotion();
        $promotion->setCode($code);
        $this->assertEquals($newCode, $promotion->__toString());
    }

    public function testGetId(): void
    {
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getUuid());
        $promotion->setUuid($uuid);
        $this->assertEquals($uuid, $promotion->getUuid());
        $this->assertIsString($promotion->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setUuid($uuid));
        $this->assertEquals($uuid, $promotion->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getCreatedBy());
        $promotion->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $promotion->getCreatedBy());
        $this->assertIsString($promotion->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $promotion->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getDeletedBy());
        $promotion->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $promotion->getDeletedBy());
        $this->assertIsString($promotion->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $promotion->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getUpdatedBy());
        $promotion->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $promotion->getUpdatedBy());
        $this->assertIsString($promotion->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $promotion->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getCreatedAt());
        $promotion->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $promotion->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $promotion->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getDeletedAt());
        $promotion->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $promotion->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $promotion->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getUpdatedAt());
        $promotion->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $promotion->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $promotion->getUpdatedAt());
    }

    public function testGetIsEnabled(): void
    {
        $isEnabled = true;
        $promotion = new Promotion();
        $this->assertTrue($promotion->getIsEnabled());
        $promotion->setIsEnabled($isEnabled);
        $this->assertEquals($isEnabled, $promotion->getIsEnabled());
        $this->assertIsBool($promotion->getIsEnabled());
    }

    public function testSetIsEnabled(): void
    {
        $isEnabled = true;
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setIsEnabled($isEnabled));
        $this->assertEquals($isEnabled, $promotion->getIsEnabled());
    }

    public function testGetCode(): void
    {
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getCode());
        $promotion->setCode($code);
        $this->assertEquals($newCode, $promotion->getCode());
        $this->assertIsString($promotion->getCode());
    }

    public function testSetCode(): void
    {
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setCode($code));
        $this->assertEquals($newCode, $promotion->getCode());
    }

    public function testGetDescription(): void
    {
        $description = 'test description';
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getDescription());
        $promotion->setDescription($description);
        $this->assertEquals($description, $promotion->getDescription());
        $this->assertIsString($promotion->getDescription());
    }

    public function testSetDescription(): void
    {
        $description = 'test description';
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setDescription($description));
        $this->assertEquals($description, $promotion->getDescription());
    }

    public function testGetNotifications(): void
    {
        $notifications = 10;
        $promotion = new Promotion();
        $promotion->setNotifications($notifications);
        $this->assertEquals($notifications, $promotion->getNotifications());
        $this->assertIsInt($promotion->getNotifications());
    }

    public function testSetNotifications(): void
    {
        $notifications = 10;
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setNotifications($notifications));
        $this->assertEquals($notifications, $promotion->getNotifications());
    }

    public function testGetExpiresAt(): void
    {
        $expiresAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $promotion->setExpiresAt($expiresAt);
        $this->assertEquals($expiresAt, $promotion->getExpiresAt());
    }

    public function testSetExpiresAt(): void
    {
        $expiresAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setExpiresAt($expiresAt));
        $this->assertEquals($expiresAt, $promotion->getExpiresAt());
    }

    public function testGetName(): void
    {
        $name = 'test name';
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getName());
        $promotion->setName($name);
        $this->assertEquals($name, $promotion->getName());
        $this->assertIsString($promotion->getName());
    }

    public function testSetName(): void
    {
        $name = 'test name';
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setName($name));
        $this->assertEquals($name, $promotion->getName());
    }

    public function testGetSmsNotifications(): void
    {
        $smsNotifications = 10;
        $promotion = new Promotion();
        $promotion->setSmsNotifications($smsNotifications);
        $this->assertEquals($smsNotifications, $promotion->getSmsNotifications());
        $this->assertIsInt($promotion->getSmsNotifications());
    }

    public function testSetSmsNotifications(): void
    {
        $smsNotifications = 10;
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setSmsNotifications($smsNotifications));
        $this->assertEquals($smsNotifications, $promotion->getSmsNotifications());
    }

    public function testGetType(): void
    {
        $type = Promotion::TYPE_EXISTING_ACCOUNT;
        $promotion = new Promotion();
        $promotion->setType($type);
        $this->assertEquals($type, $promotion->getType());
        $this->assertIsString($promotion->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(3, Promotion::getTypeFormChoices());
        $this->assertIsArray(Promotion::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(3, Promotion::getTypeValidationChoices());
        $this->assertIsArray(Promotion::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = Promotion::TYPE_EXISTING_ACCOUNT;
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setType($type));
        $this->assertEquals($type, $promotion->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setType($type));
    }

    public function testAddUser(): void
    {
        $promotion = new Promotion();
        $this->assertCount(0, $promotion->getUsers());
        $user1 = new User();
        $this->assertInstanceOf(Promotion::class, $promotion->addUser($user1));
        $this->assertCount(1, $promotion->getUsers());
        $user2 = new User();
        $this->assertInstanceOf(Promotion::class, $promotion->addUser($user2));
        $this->assertCount(2, $promotion->getUsers());
    }

    public function testGetUsers(): void
    {
        $promotion = new Promotion();
        $this->assertCount(0, $promotion->getUsers());
        $user = new User();
        $this->assertInstanceOf(Promotion::class, $promotion->addUser($user));
        $this->assertCount(1, $promotion->getUsers());
    }

    public function testRemoveUser(): void
    {
        $promotion = new Promotion();
        $this->assertCount(0, $promotion->getUsers());
        $user1 = new User();
        $this->assertInstanceOf(Promotion::class, $promotion->addUser($user1));
        $this->assertCount(1, $promotion->getUsers());
        $user2 = new User();
        $this->assertInstanceOf(Promotion::class, $promotion->addUser($user2));
        $this->assertCount(2, $promotion->getUsers());
        $this->assertInstanceOf(Promotion::class, $promotion->removeUser($user1));
    }
}
