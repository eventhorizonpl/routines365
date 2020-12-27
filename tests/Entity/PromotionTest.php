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
    public function testConstruct()
    {
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion);
    }

    public function testToString()
    {
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $promotion = new Promotion();
        $promotion->setCode($code);
        $this->assertEquals($newCode, $promotion->__toString());
    }

    public function testGetId()
    {
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getUuid());
        $promotion->setUuid($uuid);
        $this->assertEquals($uuid, $promotion->getUuid());
        $this->assertIsString($promotion->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setUuid($uuid));
        $this->assertEquals($uuid, $promotion->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getCreatedBy());
        $promotion->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $promotion->getCreatedBy());
        $this->assertIsString($promotion->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $promotion->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getDeletedBy());
        $promotion->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $promotion->getDeletedBy());
        $this->assertIsString($promotion->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $promotion->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getUpdatedBy());
        $promotion->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $promotion->getUpdatedBy());
        $this->assertIsString($promotion->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $promotion->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getCreatedAt());
        $promotion->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $promotion->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $promotion->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getDeletedAt());
        $promotion->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $promotion->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $promotion->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getUpdatedAt());
        $promotion->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $promotion->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $promotion->getUpdatedAt());
    }

    public function testGetIsEnabled()
    {
        $isEnabled = true;
        $promotion = new Promotion();
        $this->assertTrue($promotion->getIsEnabled());
        $promotion->setIsEnabled($isEnabled);
        $this->assertEquals($isEnabled, $promotion->getIsEnabled());
        $this->assertIsBool($promotion->getIsEnabled());
    }

    public function testSetIsEnabled()
    {
        $isEnabled = true;
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setIsEnabled($isEnabled));
        $this->assertEquals($isEnabled, $promotion->getIsEnabled());
    }

    public function testGetCode()
    {
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getCode());
        $promotion->setCode($code);
        $this->assertEquals($newCode, $promotion->getCode());
        $this->assertIsString($promotion->getCode());
    }

    public function testSetCode()
    {
        $code = 'test code';
        $newCode = strtoupper(preg_replace('/[^a-z0-9]/i', '', $code));
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setCode($code));
        $this->assertEquals($newCode, $promotion->getCode());
    }

    public function testGetDescription()
    {
        $description = 'test description';
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getDescription());
        $promotion->setDescription($description);
        $this->assertEquals($description, $promotion->getDescription());
        $this->assertIsString($promotion->getDescription());
    }

    public function testSetDescription()
    {
        $description = 'test description';
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setDescription($description));
        $this->assertEquals($description, $promotion->getDescription());
    }

    public function testGetEmailNotifications()
    {
        $emailNotifications = 10;
        $promotion = new Promotion();
        $promotion->setEmailNotifications($emailNotifications);
        $this->assertEquals($emailNotifications, $promotion->getEmailNotifications());
        $this->assertIsInt($promotion->getEmailNotifications());
    }

    public function testSetEmailNotifications()
    {
        $emailNotifications = 10;
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setEmailNotifications($emailNotifications));
        $this->assertEquals($emailNotifications, $promotion->getEmailNotifications());
    }

    public function testGetExpiresAt()
    {
        $expiresAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getExpiresAt());
        $promotion->setExpiresAt($expiresAt);
        $this->assertEquals($expiresAt, $promotion->getExpiresAt());
    }

    public function testSetExpiresAt()
    {
        $expiresAt = new DateTimeImmutable();
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setExpiresAt($expiresAt));
        $this->assertEquals($expiresAt, $promotion->getExpiresAt());
    }

    public function testGetName()
    {
        $name = 'test name';
        $promotion = new Promotion();
        $this->assertEquals(null, $promotion->getName());
        $promotion->setName($name);
        $this->assertEquals($name, $promotion->getName());
        $this->assertIsString($promotion->getName());
    }

    public function testSetName()
    {
        $name = 'test name';
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setName($name));
        $this->assertEquals($name, $promotion->getName());
    }

    public function testGetSmsNotifications()
    {
        $smsNotifications = 10;
        $promotion = new Promotion();
        $promotion->setSmsNotifications($smsNotifications);
        $this->assertEquals($smsNotifications, $promotion->getSmsNotifications());
        $this->assertIsInt($promotion->getSmsNotifications());
    }

    public function testSetSmsNotifications()
    {
        $smsNotifications = 10;
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setSmsNotifications($smsNotifications));
        $this->assertEquals($smsNotifications, $promotion->getSmsNotifications());
    }

    public function testGetType()
    {
        $type = Promotion::TYPE_EXISTING_ACCOUNT;
        $promotion = new Promotion();
        $promotion->setType($type);
        $this->assertEquals($type, $promotion->getType());
        $this->assertIsString($promotion->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(3, Promotion::getTypeFormChoices());
        $this->assertIsArray(Promotion::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(3, Promotion::getTypeValidationChoices());
        $this->assertIsArray(Promotion::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = Promotion::TYPE_EXISTING_ACCOUNT;
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setType($type));
        $this->assertEquals($type, $promotion->getType());
    }

    public function testSetTypeException()
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $promotion = new Promotion();
        $this->assertInstanceOf(Promotion::class, $promotion->setType($type));
    }

    public function testAddUser()
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

    public function testGetUsers()
    {
        $promotion = new Promotion();
        $this->assertCount(0, $promotion->getUsers());
        $user = new User();
        $this->assertInstanceOf(Promotion::class, $promotion->addUser($user));
        $this->assertCount(1, $promotion->getUsers());
    }

    public function testRemoveUser()
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