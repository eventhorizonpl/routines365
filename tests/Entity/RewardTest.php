<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Reward;
use App\Entity\Routine;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class RewardTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $reward = new Reward();
        $reward->setUuid($uuid);
        $this->assertEquals($uuid, $reward->__toString());
    }

    public function testGetId()
    {
        $reward = new Reward();
        $this->assertEquals(null, $reward->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertEquals(null, $reward->getUuid());
        $reward->setUuid($uuid);
        $this->assertEquals($uuid, $reward->getUuid());
        $this->assertIsString($reward->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setUuid($uuid));
        $this->assertEquals($uuid, $reward->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertEquals(null, $reward->getCreatedBy());
        $reward->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $reward->getCreatedBy());
        $this->assertIsString($reward->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $reward->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertEquals(null, $reward->getDeletedBy());
        $reward->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $reward->getDeletedBy());
        $this->assertIsString($reward->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $reward->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertEquals(null, $reward->getUpdatedBy());
        $reward->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $reward->getUpdatedBy());
        $this->assertIsString($reward->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $reward->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertEquals(null, $reward->getCreatedAt());
        $reward->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $reward->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $reward->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertEquals(null, $reward->getDeletedAt());
        $reward->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $reward->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $reward->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertEquals(null, $reward->getUpdatedAt());
        $reward->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $reward->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $reward->getUpdatedAt());
    }

    public function testGetIsAwarded()
    {
        $isAwarded = true;
        $reward = new Reward();
        $this->assertEquals(false, $reward->getIsAwarded());
        $reward->setIsAwarded($isAwarded);
        $this->assertEquals($isAwarded, $reward->getIsAwarded());
        $this->assertIsBool($reward->getIsAwarded());
    }

    public function testSetIsAwarded()
    {
        $isAwarded = true;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setIsAwarded($isAwarded));
        $this->assertEquals($isAwarded, $reward->getIsAwarded());
    }

    public function testGetRoutine()
    {
        $routine = new Routine();
        $reward = new Reward();
        $reward->setRoutine($routine);
        $this->assertEquals($routine, $reward->getRoutine());
    }

    public function testSetRoutine()
    {
        $routine = new Routine();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setRoutine($routine));
        $this->assertEquals($routine, $reward->getRoutine());
    }

    public function testGetUser()
    {
        $user = new User();
        $reward = new Reward();
        $reward->setUser($user);
        $this->assertEquals($user, $reward->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setUser($user));
        $this->assertEquals($user, $reward->getUser());
    }

    public function testGetDescription()
    {
        $description = 'test description';
        $reward = new Reward();
        $this->assertEquals(null, $reward->getDescription());
        $reward->setDescription($description);
        $this->assertEquals($description, $reward->getDescription());
        $this->assertIsString($reward->getDescription());
    }

    public function testSetDescription()
    {
        $description = 'test description';
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setDescription($description));
        $this->assertEquals($description, $reward->getDescription());
    }

    public function testGetName()
    {
        $name = 'test name';
        $reward = new Reward();
        $this->assertEquals(null, $reward->getName());
        $reward->setName($name);
        $this->assertEquals($name, $reward->getName());
        $this->assertIsString($reward->getName());
    }

    public function testSetName()
    {
        $name = 'test name';
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setName($name));
        $this->assertEquals($name, $reward->getName());
    }

    public function testIncrementNumberOfCompletions()
    {
        $reward = new Reward();
        $this->assertEquals(0, $reward->getNumberOfCompletions());
        $this->assertInstanceOf(Reward::class, $reward->incrementNumberOfCompletions());
        $this->assertEquals(1, $reward->getNumberOfCompletions());
    }

    public function testGetNumberOfCompletions()
    {
        $numberOfCompletions = 10;
        $reward = new Reward();
        $this->assertEquals(0, $reward->getNumberOfCompletions());
        $reward->setNumberOfCompletions($numberOfCompletions);
        $this->assertEquals($numberOfCompletions, $reward->getNumberOfCompletions());
        $this->assertIsInt($reward->getNumberOfCompletions());
    }

    public function testGetNumberOfCompletionsPercent()
    {
        $requiredNumberOfCompletions = 5;
        $numberOfCompletions = 2;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setRequiredNumberOfCompletions($requiredNumberOfCompletions));
        $this->assertInstanceOf(Reward::class, $reward->setNumberOfCompletions($numberOfCompletions));
        $this->assertEquals(40, $reward->getNumberOfCompletionsPercent());
    }

    public function testSetNumberOfCompletions()
    {
        $numberOfCompletions = 10;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setNumberOfCompletions($numberOfCompletions));
        $this->assertEquals($numberOfCompletions, $reward->getNumberOfCompletions());
    }

    public function testGetRequiredNumberOfCompletions()
    {
        $requiredNumberOfCompletions = 5;
        $reward = new Reward();
        $reward->setRequiredNumberOfCompletions($requiredNumberOfCompletions);
        $this->assertEquals($requiredNumberOfCompletions, $reward->getRequiredNumberOfCompletions());
        $this->assertIsInt($reward->getRequiredNumberOfCompletions());
    }

    public function testGetRequiredNumberOfCompletionsFormChoices()
    {
        $this->assertCount(12, Reward::getRequiredNumberOfCompletionsFormChoices());
        $this->assertIsArray(Reward::getRequiredNumberOfCompletionsFormChoices());
    }

    public function testGetRequiredNumberOfCompletionsValidationChoices()
    {
        $this->assertCount(12, Reward::getRequiredNumberOfCompletionsValidationChoices());
        $this->assertIsArray(Reward::getRequiredNumberOfCompletionsValidationChoices());
    }

    public function testSetRequiredNumberOfCompletions()
    {
        $requiredNumberOfCompletions = 5;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setRequiredNumberOfCompletions($requiredNumberOfCompletions));
        $this->assertEquals($requiredNumberOfCompletions, $reward->getRequiredNumberOfCompletions());
    }

    public function testGetType()
    {
        $type = Reward::TYPE_ALL;
        $reward = new Reward();
        $reward->setType($type);
        $this->assertEquals($type, $reward->getType());
        $this->assertIsString($reward->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(3, Reward::getTypeFormChoices());
        $this->assertIsArray(Reward::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(3, Reward::getTypeValidationChoices());
        $this->assertIsArray(Reward::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = Reward::TYPE_ALL;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setType($type));
        $this->assertEquals($type, $reward->getType());
    }
}
