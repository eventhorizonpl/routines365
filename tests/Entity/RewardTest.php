<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{Reward, Routine, User};
use App\Enum\RewardTypeEnum;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
final class RewardTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $reward = new Reward();
        $reward->setUuid($uuid);
        $this->assertSame($uuid, $reward->__toString());
    }

    public function testGetId(): void
    {
        $reward = new Reward();
        $this->assertNull($reward->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertNull($reward->getUuid());
        $reward->setUuid($uuid);
        $this->assertSame($uuid, $reward->getUuid());
        $this->assertIsString($reward->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setUuid($uuid));
        $this->assertSame($uuid, $reward->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertNull($reward->getCreatedBy());
        $reward->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $reward->getCreatedBy());
        $this->assertIsString($reward->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $reward->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertNull($reward->getDeletedBy());
        $reward->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $reward->getDeletedBy());
        $this->assertIsString($reward->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $reward->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertNull($reward->getUpdatedBy());
        $reward->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $reward->getUpdatedBy());
        $this->assertIsString($reward->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $reward->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertNull($reward->getCreatedAt());
        $reward->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $reward->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $reward->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertNull($reward->getDeletedAt());
        $reward->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $reward->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $reward->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertNull($reward->getUpdatedAt());
        $reward->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $reward->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $reward->getUpdatedAt());
    }

    public function testGetIsAwarded(): void
    {
        $isAwarded = true;
        $reward = new Reward();
        $this->assertFalse($reward->getIsAwarded());
        $reward->setIsAwarded($isAwarded);
        $this->assertSame($isAwarded, $reward->getIsAwarded());
        $this->assertIsBool($reward->getIsAwarded());
    }

    public function testSetIsAwarded(): void
    {
        $isAwarded = true;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setIsAwarded($isAwarded));
        $this->assertSame($isAwarded, $reward->getIsAwarded());
    }

    public function testGetRoutine(): void
    {
        $routine = new Routine();
        $reward = new Reward();
        $reward->setRoutine($routine);
        $this->assertSame($routine, $reward->getRoutine());
    }

    public function testSetRoutine(): void
    {
        $routine = new Routine();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setRoutine($routine));
        $this->assertSame($routine, $reward->getRoutine());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $reward = new Reward();
        $reward->setUser($user);
        $this->assertSame($user, $reward->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setUser($user));
        $this->assertSame($user, $reward->getUser());
    }

    public function testGetDescription(): void
    {
        $description = 'test description';
        $reward = new Reward();
        $this->assertNull($reward->getDescription());
        $reward->setDescription($description);
        $this->assertSame($description, $reward->getDescription());
        $this->assertIsString($reward->getDescription());
    }

    public function testSetDescription(): void
    {
        $description = 'test description';
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setDescription($description));
        $this->assertSame($description, $reward->getDescription());
    }

    public function testGetName(): void
    {
        $name = 'test name';
        $reward = new Reward();
        $this->assertSame('', $reward->getName());
        $reward->setName($name);
        $this->assertSame($name, $reward->getName());
        $this->assertIsString($reward->getName());
    }

    public function testSetName(): void
    {
        $name = 'test name';
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setName($name));
        $this->assertSame($name, $reward->getName());
    }

    public function testIncrementNumberOfCompletions(): void
    {
        $reward = new Reward();
        $this->assertSame(0, $reward->getNumberOfCompletions());
        $this->assertInstanceOf(Reward::class, $reward->incrementNumberOfCompletions());
        $this->assertSame(1, $reward->getNumberOfCompletions());
    }

    public function testGetNumberOfCompletions(): void
    {
        $numberOfCompletions = 10;
        $reward = new Reward();
        $this->assertSame(0, $reward->getNumberOfCompletions());
        $reward->setNumberOfCompletions($numberOfCompletions);
        $this->assertSame($numberOfCompletions, $reward->getNumberOfCompletions());
        $this->assertIsInt($reward->getNumberOfCompletions());
    }

    public function testGetNumberOfCompletionsPercent(): void
    {
        $requiredNumberOfCompletions = 5;
        $numberOfCompletions = 2;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setRequiredNumberOfCompletions($requiredNumberOfCompletions));
        $this->assertInstanceOf(Reward::class, $reward->setNumberOfCompletions($numberOfCompletions));
        $this->assertSame(40, $reward->getNumberOfCompletionsPercent());
    }

    public function testSetNumberOfCompletions(): void
    {
        $numberOfCompletions = 10;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setNumberOfCompletions($numberOfCompletions));
        $this->assertSame($numberOfCompletions, $reward->getNumberOfCompletions());
    }

    public function testGetRequiredNumberOfCompletions(): void
    {
        $requiredNumberOfCompletions = 5;
        $reward = new Reward();
        $reward->setRequiredNumberOfCompletions($requiredNumberOfCompletions);
        $this->assertSame($requiredNumberOfCompletions, $reward->getRequiredNumberOfCompletions());
        $this->assertIsInt($reward->getRequiredNumberOfCompletions());
    }

    public function testGetRequiredNumberOfCompletionsFormChoices(): void
    {
        $this->assertCount(12, Reward::getRequiredNumberOfCompletionsFormChoices());
        $this->assertIsArray(Reward::getRequiredNumberOfCompletionsFormChoices());
    }

    public function testGetRequiredNumberOfCompletionsValidationChoices(): void
    {
        $this->assertCount(12, Reward::getRequiredNumberOfCompletionsValidationChoices());
        $this->assertIsArray(Reward::getRequiredNumberOfCompletionsValidationChoices());
    }

    public function testSetRequiredNumberOfCompletions(): void
    {
        $requiredNumberOfCompletions = 5;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setRequiredNumberOfCompletions($requiredNumberOfCompletions));
        $this->assertSame($requiredNumberOfCompletions, $reward->getRequiredNumberOfCompletions());
    }

    public function testGetType(): void
    {
        $type = RewardTypeEnum::ALL;
        $reward = new Reward();
        $reward->setType($type);
        $this->assertSame($type, $reward->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(3, Reward::getTypeFormChoices());
        $this->assertIsArray(Reward::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(3, Reward::getTypeValidationChoices());
        $this->assertIsArray(Reward::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = RewardTypeEnum::ALL;
        $reward = new Reward();
        $this->assertInstanceOf(Reward::class, $reward->setType($type));
        $this->assertSame($type, $reward->getType());
    }
}
