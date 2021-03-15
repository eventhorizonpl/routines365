<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Achievement;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 * @coversNothing
 */
final class AchievementTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $achievement = new Achievement();
        $achievement->setUuid($uuid);
        $this->assertSame($uuid, $achievement->__toString());
    }

    public function testGetId(): void
    {
        $achievement = new Achievement();
        $this->assertNull($achievement->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertNull($achievement->getUuid());
        $achievement->setUuid($uuid);
        $this->assertSame($uuid, $achievement->getUuid());
        $this->assertIsString($achievement->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setUuid($uuid));
        $this->assertSame($uuid, $achievement->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertNull($achievement->getCreatedBy());
        $achievement->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $achievement->getCreatedBy());
        $this->assertIsString($achievement->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $achievement->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertNull($achievement->getDeletedBy());
        $achievement->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $achievement->getDeletedBy());
        $this->assertIsString($achievement->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $achievement->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertNull($achievement->getUpdatedBy());
        $achievement->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $achievement->getUpdatedBy());
        $this->assertIsString($achievement->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $achievement->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertNull($achievement->getCreatedAt());
        $achievement->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $achievement->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $achievement->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertNull($achievement->getDeletedAt());
        $achievement->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $achievement->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $achievement->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertNull($achievement->getUpdatedAt());
        $achievement->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $achievement->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $achievement->getUpdatedAt());
    }

    public function testGetIsEnabled(): void
    {
        $isEnabled = true;
        $achievement = new Achievement();
        $this->assertTrue($achievement->getIsEnabled());
        $achievement->setIsEnabled($isEnabled);
        $this->assertSame($isEnabled, $achievement->getIsEnabled());
        $this->assertIsBool($achievement->getIsEnabled());
    }

    public function testSetIsEnabled(): void
    {
        $isEnabled = true;
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setIsEnabled($isEnabled));
        $this->assertSame($isEnabled, $achievement->getIsEnabled());
    }

    public function testGetDescription(): void
    {
        $description = 'test description';
        $achievement = new Achievement();
        $this->assertNull($achievement->getDescription());
        $achievement->setDescription($description);
        $this->assertSame($description, $achievement->getDescription());
        $this->assertIsString($achievement->getDescription());
    }

    public function testSetDescription(): void
    {
        $description = 'test description';
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setDescription($description));
        $this->assertSame($description, $achievement->getDescription());
    }

    public function testGetLevel(): void
    {
        $level = 10;
        $achievement = new Achievement();
        $achievement->setLevel($level);
        $this->assertSame($level, $achievement->getLevel());
        $this->assertIsInt($achievement->getLevel());
    }

    public function testSetLevel(): void
    {
        $level = 10;
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setLevel($level));
        $this->assertSame($level, $achievement->getLevel());
    }

    public function testGetName(): void
    {
        $name = 'test name';
        $achievement = new Achievement();
        $this->assertSame('', $achievement->getName());
        $achievement->setName($name);
        $this->assertSame($name, $achievement->getName());
        $this->assertIsString($achievement->getName());
    }

    public function testSetName(): void
    {
        $name = 'test name';
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setName($name));
        $this->assertSame($name, $achievement->getName());
    }

    public function testGetRequirement(): void
    {
        $requirement = 10;
        $achievement = new Achievement();
        $achievement->setRequirement($requirement);
        $this->assertSame($requirement, $achievement->getRequirement());
        $this->assertIsInt($achievement->getRequirement());
    }

    public function testSetRequirement(): void
    {
        $requirement = 10;
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setRequirement($requirement));
        $this->assertSame($requirement, $achievement->getRequirement());
    }

    public function testGetType(): void
    {
        $type = Achievement::TYPE_COMPLETED_ROUTINE;
        $achievement = new Achievement();
        $achievement->setType($type);
        $this->assertSame($type, $achievement->getType());
        $this->assertIsString($achievement->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(4, Achievement::getTypeFormChoices());
        $this->assertIsArray(Achievement::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(4, Achievement::getTypeValidationChoices());
        $this->assertIsArray(Achievement::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = Achievement::TYPE_COMPLETED_ROUTINE;
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setType($type));
        $this->assertSame($type, $achievement->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $achievement = new Achievement();
        $this->assertInstanceOf(Achievement::class, $achievement->setType($type));
    }

    public function testAddUser(): void
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

    public function testGetUsers(): void
    {
        $achievement = new Achievement();
        $this->assertCount(0, $achievement->getUsers());
        $user = new User();
        $this->assertInstanceOf(Achievement::class, $achievement->addUser($user));
        $this->assertCount(1, $achievement->getUsers());
    }

    public function testRemoveUser(): void
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
