<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Achievement;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final class AchievementTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $achievement = new Achievement();
        $achievement->setUuid($uuid);
        $this->assertEquals($uuid, $achievement->__toString());
    }

    public function testGetId()
    {
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getUuid());
        $achievement->setUuid($uuid);
        $this->assertEquals($uuid, $achievement->getUuid());
        $this->assertIsString($achievement->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setUuid($uuid));
        $this->assertEquals($uuid, $achievement->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getCreatedBy());
        $achievement->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $achievement->getCreatedBy());
        $this->assertIsString($achievement->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $achievement->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getDeletedBy());
        $achievement->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $achievement->getDeletedBy());
        $this->assertIsString($achievement->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $achievement->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getUpdatedBy());
        $achievement->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $achievement->getUpdatedBy());
        $this->assertIsString($achievement->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $achievement->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getCreatedAt());
        $achievement->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $achievement->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $achievement->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getDeletedAt());
        $achievement->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $achievement->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $achievement->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getUpdatedAt());
        $achievement->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $achievement->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $achievement->getUpdatedAt());
    }

    public function testGetIsEnabled()
    {
        $isEnabled = true;
        $achievement = new Achievement();
        $this->assertTrue($achievement->getIsEnabled());
        $achievement->setIsEnabled($isEnabled);
        $this->assertEquals($isEnabled, $achievement->getIsEnabled());
        $this->assertIsBool($achievement->getIsEnabled());
    }

    public function testSetIsEnabled()
    {
        $isEnabled = true;
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setIsEnabled($isEnabled));
        $this->assertEquals($isEnabled, $achievement->getIsEnabled());
    }

    public function testGetDescription()
    {
        $description = 'test description';
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getDescription());
        $achievement->setDescription($description);
        $this->assertEquals($description, $achievement->getDescription());
        $this->assertIsString($achievement->getDescription());
    }

    public function testSetDescription()
    {
        $description = 'test description';
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setDescription($description));
        $this->assertEquals($description, $achievement->getDescription());
    }

    public function testGetLevel()
    {
        $level = 10;
        $achievement = new Achievement();
        $achievement->setLevel($level);
        $this->assertEquals($level, $achievement->getLevel());
        $this->assertIsInt($achievement->getLevel());
    }

    public function testSetLevel()
    {
        $level = 10;
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setLevel($level));
        $this->assertEquals($level, $achievement->getLevel());
    }

    public function testGetName()
    {
        $name = 'test name';
        $achievement = new Achievement();
        $this->assertEquals(null, $achievement->getName());
        $achievement->setName($name);
        $this->assertEquals($name, $achievement->getName());
        $this->assertIsString($achievement->getName());
    }

    public function testSetName()
    {
        $name = 'test name';
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setName($name));
        $this->assertEquals($name, $achievement->getName());
    }

    public function testGetRequirement()
    {
        $requirement = 10;
        $achievement = new Achievement();
        $achievement->setRequirement($requirement);
        $this->assertEquals($requirement, $achievement->getRequirement());
        $this->assertIsInt($achievement->getRequirement());
    }

    public function testSetRequirement()
    {
        $requirement = 10;
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setRequirement($requirement));
        $this->assertEquals($requirement, $achievement->getRequirement());
    }

    public function testGetType()
    {
        $type = Achievement::TYPE_COMPLETED_ROUTINE;
        $achievement = new Achievement();
        $achievement->setType($type);
        $this->assertEquals($type, $achievement->getType());
        $this->assertIsString($achievement->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(4, Achievement::getTypeFormChoices());
        $this->assertIsArray(Achievement::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(4, Achievement::getTypeValidationChoices());
        $this->assertIsArray(Achievement::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = Achievement::TYPE_COMPLETED_ROUTINE;
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setType($type));
        $this->assertEquals($type, $achievement->getType());
    }

    public function testSetTypeException()
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setType($type));
    }

    public function testAddUser()
    {
        $achievement = new Achievement();
        $this->assertCount(0, $achievement->getUsers());
        $user1 = new User();
        $this->assertInstanceOf(Achievement::class, $achievement->addUser($user1));
        $this->assertCount(1, $achievement->getUsers());
        $user2 = new User();
        $this->assertInstanceOf(Achievement::class, $achievement->addUser($user2));
        $this->assertCount(2, $achievement->getUsers());
    }

    public function testGetUsers()
    {
        $achievement = new Achievement();
        $this->assertCount(0, $achievement->getUsers());
        $user = new User();
        $this->assertInstanceOf(Achievement::class, $achievement->addUser($user));
        $this->assertCount(1, $achievement->getUsers());
    }

    public function testRemoveUser()
    {
        $achievement = new Achievement();
        $this->assertCount(0, $achievement->getUsers());
        $user1 = new User();
        $this->assertInstanceOf(Achievement::class, $achievement->addUser($user1));
        $this->assertCount(1, $achievement->getUsers());
        $user2 = new User();
        $this->assertInstanceOf(Achievement::class, $achievement->addUser($user2));
        $this->assertCount(2, $achievement->getUsers());
        $this->assertInstanceOf(Achievement::class, $achievement->removeUser($user1));
    }
}