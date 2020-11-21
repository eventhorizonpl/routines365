<?php

namespace App\Tests\Entity;

use App\Entity\Goal;
use App\Entity\Project;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class ProjectTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project);
    }

    public function testToString()
    {
        $name = 'test name';
        $project = new Project();
        $project->setName($name);
        $this->assertEquals($name, $project->__toString());
    }

    public function testGetId()
    {
        $project = new Project();
        $this->assertEquals(null, $project->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $project = new Project();
        $this->assertEquals(null, $project->getUuid());
        $project->setUuid($uuid);
        $this->assertEquals($uuid, $project->getUuid());
        $this->assertIsString($project->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setUuid($uuid));
        $this->assertEquals($uuid, $project->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertEquals(null, $project->getCreatedBy());
        $project->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $project->getCreatedBy());
        $this->assertIsString($project->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $project->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertEquals(null, $project->getDeletedBy());
        $project->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $project->getDeletedBy());
        $this->assertIsString($project->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $project->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertEquals(null, $project->getUpdatedBy());
        $project->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $project->getUpdatedBy());
        $this->assertIsString($project->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $project->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertEquals(null, $project->getCreatedAt());
        $project->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $project->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $project->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertEquals(null, $project->getDeletedAt());
        $project->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $project->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $project->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertEquals(null, $project->getUpdatedAt());
        $project->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $project->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $project->getUpdatedAt());
    }

    public function testGetIsCompleted()
    {
        $isCompleted = true;
        $project = new Project();
        $this->assertEquals(null, $project->getIsCompleted());
        $project->setIsCompleted($isCompleted);
        $this->assertEquals($isCompleted, $project->getIsCompleted());
        $this->assertIsBool($project->getIsCompleted());
    }

    public function testSetIsCompleted()
    {
        $isCompleted = true;
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setIsCompleted($isCompleted));
        $this->assertEquals($isCompleted, $project->getIsCompleted());
    }

    public function testAddGoal()
    {
        $project = new Project();
        $this->assertCount(0, $project->getGoals());
        $goal1 = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal1));
        $this->assertCount(1, $project->getGoals());
        $goal2 = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal2));
        $this->assertCount(2, $project->getGoals());
        $deletedAt = new DateTimeImmutable();
        $goal2->setDeletedAt($deletedAt);
        $this->assertCount(1, $project->getGoals());
    }

    public function testGetGoals()
    {
        $project = new Project();
        $this->assertCount(0, $project->getGoals());
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertCount(1, $project->getGoals());
    }

    public function testGetGoalsAll()
    {
        $project = new Project();
        $this->assertCount(0, $project->getGoalsAll());
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertCount(1, $project->getGoalsAll());
        $deletedAt = new DateTimeImmutable();
        $goal->setDeletedAt($deletedAt);
        $this->assertCount(1, $project->getGoalsAll());
    }

    public function testGetGoalsCompleted()
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertCount(0, $project->getGoalsCompleted());
        $goal->setIsCompleted(true);
        $this->assertCount(1, $project->getGoalsCompleted());
    }

    public function testGetGoalsCompletedCount()
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertEquals(0, $project->getGoalsCompletedCount());
        $goal->setIsCompleted(true);
        $this->assertEquals(1, $project->getGoalsCompletedCount());
    }

    public function testGetGoalsCompletedPercent()
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertEquals(0, $project->getGoalsCompletedPercent());
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertEquals(0, $project->getGoalsCompletedPercent());
        $goal->setIsCompleted(true);
        $this->assertEquals(100, $project->getGoalsCompletedPercent());
        $goal2 = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal2));
        $this->assertEquals(50, $project->getGoalsCompletedPercent());
    }

    public function testGetGoalsNotCompleted()
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertCount(1, $project->getGoalsNotCompleted());
        $goal->setIsCompleted(true);
        $this->assertCount(0, $project->getGoalsNotCompleted());
    }

    public function testGetGoalsNotCompletedCount()
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertEquals(1, $project->getGoalsNotCompletedCount());
        $goal->setIsCompleted(true);
        $this->assertEquals(0, $project->getGoalsNotCompletedCount());
    }

    public function testGetGoalsNotCompletedPercent()
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertEquals(0, $project->getGoalsNotCompletedPercent());
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertEquals(100, $project->getGoalsNotCompletedPercent());
        $goal->setIsCompleted(true);
        $this->assertEquals(0, $project->getGoalsNotCompletedPercent());
        $goal2 = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal2));
        $this->assertEquals(50, $project->getGoalsNotCompletedPercent());
    }

    public function testRemoveGoal()
    {
        $project = new Project();
        $this->assertCount(0, $project->getGoals());
        $goal1 = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal1));
        $this->assertCount(1, $project->getGoals());
        $goal2 = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal2));
        $this->assertCount(2, $project->getGoals());
        $this->assertInstanceOf(Project::class, $project->removeGoal($goal1));
    }

    public function testGetUser()
    {
        $user = new User();
        $project = new Project();
        $project->setUser($user);
        $this->assertEquals($user, $project->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setUser($user));
        $this->assertEquals($user, $project->getUser());
    }

    public function testGetDescription()
    {
        $description = 'test description';
        $project = new Project();
        $this->assertEquals(null, $project->getDescription());
        $project->setDescription($description);
        $this->assertEquals($description, $project->getDescription());
        $this->assertIsString($project->getDescription());
    }

    public function testSetDescription()
    {
        $description = 'test description';
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setDescription($description));
        $this->assertEquals($description, $project->getDescription());
    }

    public function testGetName()
    {
        $name = 'test name';
        $project = new Project();
        $this->assertEquals(null, $project->getName());
        $project->setName($name);
        $this->assertEquals($name, $project->getName());
        $this->assertIsString($project->getName());
    }

    public function testSetName()
    {
        $name = 'test name';
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setName($name));
        $this->assertEquals($name, $project->getName());
    }
}
