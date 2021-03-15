<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Goal;
use App\Entity\Project;
use App\Entity\Routine;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 * @coversNothing
 */
final class GoalTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $goal = new Goal();
        $goal->setUuid($uuid);
        $this->assertSame($uuid, $goal->__toString());
    }

    public function testGetId(): void
    {
        $goal = new Goal();
        $this->assertNull($goal->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertNull($goal->getUuid());
        $goal->setUuid($uuid);
        $this->assertSame($uuid, $goal->getUuid());
        $this->assertIsString($goal->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setUuid($uuid));
        $this->assertSame($uuid, $goal->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertNull($goal->getCreatedBy());
        $goal->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $goal->getCreatedBy());
        $this->assertIsString($goal->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $goal->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertNull($goal->getDeletedBy());
        $goal->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $goal->getDeletedBy());
        $this->assertIsString($goal->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $goal->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertNull($goal->getUpdatedBy());
        $goal->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $goal->getUpdatedBy());
        $this->assertIsString($goal->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $goal->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertNull($goal->getCreatedAt());
        $goal->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $goal->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $goal->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertNull($goal->getDeletedAt());
        $goal->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $goal->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $goal->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertNull($goal->getUpdatedAt());
        $goal->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $goal->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $goal->getUpdatedAt());
    }

    public function testGetCompletedAt(): void
    {
        $completedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertNull($goal->getCompletedAt());
        $goal->setCompletedAt($completedAt);
        $this->assertSame($completedAt, $goal->getCompletedAt());
    }

    public function testSetCompletedAt(): void
    {
        $completedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setCompletedAt($completedAt));
        $this->assertSame($completedAt, $goal->getCompletedAt());
    }

    public function testGetIsCompleted(): void
    {
        $isCompleted = true;
        $goal = new Goal();
        $this->assertFalse($goal->getIsCompleted());
        $goal->setIsCompleted($isCompleted);
        $this->assertSame($isCompleted, $goal->getIsCompleted());
        $this->assertIsBool($goal->getIsCompleted());
    }

    public function testSetIsCompleted(): void
    {
        $isCompleted = true;
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setIsCompleted($isCompleted));
        $this->assertSame($isCompleted, $goal->getIsCompleted());
    }

    public function testGetProject(): void
    {
        $project = new Project();
        $goal = new Goal();
        $goal->setProject($project);
        $this->assertSame($project, $goal->getProject());
    }

    public function testSetProject(): void
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setProject($project));
        $this->assertSame($project, $goal->getProject());
    }

    public function testGetRoutine(): void
    {
        $routine = new Routine();
        $goal = new Goal();
        $goal->setRoutine($routine);
        $this->assertSame($routine, $goal->getRoutine());
    }

    public function testSetRoutine(): void
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setRoutine($routine));
        $this->assertSame($routine, $goal->getRoutine());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $goal = new Goal();
        $goal->setUser($user);
        $this->assertSame($user, $goal->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setUser($user));
        $this->assertSame($user, $goal->getUser());
    }

    public function testGetDescription(): void
    {
        $description = 'test description';
        $goal = new Goal();
        $this->assertNull($goal->getDescription());
        $goal->setDescription($description);
        $this->assertSame($description, $goal->getDescription());
        $this->assertIsString($goal->getDescription());
    }

    public function testSetDescription(): void
    {
        $description = 'test description';
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setDescription($description));
        $this->assertSame($description, $goal->getDescription());
    }

    public function testGetName(): void
    {
        $name = 'test name';
        $goal = new Goal();
        $this->assertSame('', $goal->getName());
        $goal->setName($name);
        $this->assertSame($name, $goal->getName());
        $this->assertIsString($goal->getName());
    }

    public function testSetName(): void
    {
        $name = 'test name';
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setName($name));
        $this->assertSame($name, $goal->getName());
    }
}
