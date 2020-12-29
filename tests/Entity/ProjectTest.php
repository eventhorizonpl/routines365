<?php

namespace App\Tests\Entity;

use App\Entity\Goal;
use App\Entity\Project;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class ProjectTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project);
    }

    public function testToString(): void
    {
        $name = 'test name';
        $project = new Project();
        $project->setName($name);
        $this->assertEquals($name, $project->__toString());
    }

    public function testGetId(): void
    {
        $project = new Project();
        $this->assertEquals(null, $project->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $project = new Project();
        $this->assertEquals(null, $project->getUuid());
        $project->setUuid($uuid);
        $this->assertEquals($uuid, $project->getUuid());
        $this->assertIsString($project->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setUuid($uuid));
        $this->assertEquals($uuid, $project->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertEquals(null, $project->getCreatedBy());
        $project->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $project->getCreatedBy());
        $this->assertIsString($project->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $project->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertEquals(null, $project->getDeletedBy());
        $project->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $project->getDeletedBy());
        $this->assertIsString($project->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $project->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertEquals(null, $project->getUpdatedBy());
        $project->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $project->getUpdatedBy());
        $this->assertIsString($project->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $project->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertEquals(null, $project->getCreatedAt());
        $project->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $project->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $project->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertEquals(null, $project->getDeletedAt());
        $project->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $project->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $project->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertEquals(null, $project->getUpdatedAt());
        $project->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $project->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $project->getUpdatedAt());
    }

    public function testGetCompletedAt(): void
    {
        $completedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertEquals(null, $project->getCompletedAt());
        $project->setCompletedAt($completedAt);
        $this->assertEquals($completedAt, $project->getCompletedAt());
    }

    public function testSetCompletedAt(): void
    {
        $completedAt = new DateTimeImmutable();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setCompletedAt($completedAt));
        $this->assertEquals($completedAt, $project->getCompletedAt());
    }

    public function testGetIsCompleted(): void
    {
        $isCompleted = true;
        $project = new Project();
        $this->assertEquals(null, $project->getIsCompleted());
        $project->setIsCompleted($isCompleted);
        $this->assertEquals($isCompleted, $project->getIsCompleted());
        $this->assertIsBool($project->getIsCompleted());
    }

    public function testSetIsCompleted(): void
    {
        $isCompleted = true;
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setIsCompleted($isCompleted));
        $this->assertEquals($isCompleted, $project->getIsCompleted());
    }

    public function testAddGoal(): void
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

    public function testGetGoals(): void
    {
        $project = new Project();
        $this->assertCount(0, $project->getGoals());
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertCount(1, $project->getGoals());
    }

    public function testGetGoalsAll(): void
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

    public function testGetGoalsCompleted(): void
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertCount(0, $project->getGoalsCompleted());
        $goal->setIsCompleted(true);
        $this->assertCount(1, $project->getGoalsCompleted());
    }

    public function testGetGoalsCompletedCount(): void
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertEquals(0, $project->getGoalsCompletedCount());
        $goal->setIsCompleted(true);
        $this->assertEquals(1, $project->getGoalsCompletedCount());
    }

    public function testGetGoalsCompletedPercent(): void
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

    public function testGetGoalsNotCompleted(): void
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertCount(1, $project->getGoalsNotCompleted());
        $goal->setIsCompleted(true);
        $this->assertCount(0, $project->getGoalsNotCompleted());
    }

    public function testGetGoalsNotCompletedCount(): void
    {
        $project = new Project();
        $goal = new Goal();
        $this->assertInstanceOf(Project::class, $project->addGoal($goal));
        $this->assertEquals(1, $project->getGoalsNotCompletedCount());
        $goal->setIsCompleted(true);
        $this->assertEquals(0, $project->getGoalsNotCompletedCount());
    }

    public function testGetGoalsNotCompletedPercent(): void
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

    public function testRemoveGoal(): void
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

    public function testGetUser(): void
    {
        $user = new User();
        $project = new Project();
        $project->setUser($user);
        $this->assertEquals($user, $project->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setUser($user));
        $this->assertEquals($user, $project->getUser());
    }

    public function testGetDescription(): void
    {
        $description = 'test description';
        $project = new Project();
        $this->assertEquals(null, $project->getDescription());
        $project->setDescription($description);
        $this->assertEquals($description, $project->getDescription());
        $this->assertIsString($project->getDescription());
    }

    public function testSetDescription(): void
    {
        $description = 'test description';
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setDescription($description));
        $this->assertEquals($description, $project->getDescription());
    }

    public function testGetName(): void
    {
        $name = 'test name';
        $project = new Project();
        $this->assertEquals(null, $project->getName());
        $project->setName($name);
        $this->assertEquals($name, $project->getName());
        $this->assertIsString($project->getName());
    }

    public function testSetName(): void
    {
        $name = 'test name';
        $project = new Project();
        $this->assertInstanceOf(Project::class, $project->setName($name));
        $this->assertEquals($name, $project->getName());
    }
}
