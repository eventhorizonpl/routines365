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

final class GoalTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $goal = new Goal();
        $goal->setUuid($uuid);
        $this->assertEquals($uuid, $goal->__toString());
    }

    public function testGetId()
    {
        $goal = new Goal();
        $this->assertEquals(null, $goal->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertEquals(null, $goal->getUuid());
        $goal->setUuid($uuid);
        $this->assertEquals($uuid, $goal->getUuid());
        $this->assertIsString($goal->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setUuid($uuid));
        $this->assertEquals($uuid, $goal->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertEquals(null, $goal->getCreatedBy());
        $goal->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $goal->getCreatedBy());
        $this->assertIsString($goal->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $goal->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertEquals(null, $goal->getDeletedBy());
        $goal->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $goal->getDeletedBy());
        $this->assertIsString($goal->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $goal->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertEquals(null, $goal->getUpdatedBy());
        $goal->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $goal->getUpdatedBy());
        $this->assertIsString($goal->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $goal->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertEquals(null, $goal->getCreatedAt());
        $goal->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $goal->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $goal->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertEquals(null, $goal->getDeletedAt());
        $goal->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $goal->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $goal->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertEquals(null, $goal->getUpdatedAt());
        $goal->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $goal->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $goal->getUpdatedAt());
    }

    public function testGetIsCompleted()
    {
        $isCompleted = true;
        $goal = new Goal();
        $this->assertEquals(null, $goal->getIsCompleted());
        $goal->setIsCompleted($isCompleted);
        $this->assertEquals($isCompleted, $goal->getIsCompleted());
        $this->assertIsBool($goal->getIsCompleted());
    }

    public function testSetIsCompleted()
    {
        $isCompleted = true;
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setIsCompleted($isCompleted));
        $this->assertEquals($isCompleted, $goal->getIsCompleted());
    }

    public function testGetProject()
    {
        $project = new Project();
        $goal = new Goal();
        $goal->setProject($project);
        $this->assertEquals($project, $goal->getProject());
    }

    public function testSetProject()
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setProject($project));
        $this->assertEquals($project, $goal->getProject());
    }

    public function testGetRoutine()
    {
        $routine = new Routine();
        $goal = new Goal();
        $goal->setRoutine($routine);
        $this->assertEquals($routine, $goal->getRoutine());
    }

    public function testSetRoutine()
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setRoutine($routine));
        $this->assertEquals($routine, $goal->getRoutine());
    }

    public function testGetUser()
    {
        $user = new User();
        $goal = new Goal();
        $goal->setUser($user);
        $this->assertEquals($user, $goal->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setUser($user));
        $this->assertEquals($user, $goal->getUser());
    }

    public function testGetDescription()
    {
        $description = 'test description';
        $goal = new Goal();
        $this->assertEquals(null, $goal->getDescription());
        $goal->setDescription($description);
        $this->assertEquals($description, $goal->getDescription());
        $this->assertIsString($goal->getDescription());
    }

    public function testSetDescription()
    {
        $description = 'test description';
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setDescription($description));
        $this->assertEquals($description, $goal->getDescription());
    }

    public function testGetName()
    {
        $name = 'test name';
        $goal = new Goal();
        $this->assertEquals(null, $goal->getName());
        $goal->setName($name);
        $this->assertEquals($name, $goal->getName());
        $this->assertIsString($goal->getName());
    }

    public function testSetName()
    {
        $name = 'test name';
        $goal = new Goal();
        $this->assertInstanceOf(Goal::class, $goal->setName($name));
        $this->assertEquals($name, $goal->getName());
    }
}
