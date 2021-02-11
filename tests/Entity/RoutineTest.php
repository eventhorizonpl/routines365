<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\CompletedRoutine;
use App\Entity\Goal;
use App\Entity\Note;
use App\Entity\Reminder;
use App\Entity\Reward;
use App\Entity\Routine;
use App\Entity\SentReminder;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final class RoutineTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine);
    }

    public function testToString(): void
    {
        $name = 'test name';
        $routine = new Routine();
        $routine->setName($name);
        $this->assertEquals($name, $routine->__toString());
    }

    public function testGetId(): void
    {
        $routine = new Routine();
        $this->assertEquals(null, $routine->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getUuid());
        $routine->setUuid($uuid);
        $this->assertEquals($uuid, $routine->getUuid());
        $this->assertIsString($routine->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setUuid($uuid));
        $this->assertEquals($uuid, $routine->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getCreatedBy());
        $routine->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $routine->getCreatedBy());
        $this->assertIsString($routine->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $routine->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getDeletedBy());
        $routine->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $routine->getDeletedBy());
        $this->assertIsString($routine->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $routine->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getUpdatedBy());
        $routine->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $routine->getUpdatedBy());
        $this->assertIsString($routine->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $routine->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getCreatedAt());
        $routine->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $routine->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $routine->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getDeletedAt());
        $routine->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $routine->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $routine->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getUpdatedAt());
        $routine->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $routine->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $routine->getUpdatedAt());
    }

    public function testGetIsEnabled(): void
    {
        $isEnabled = true;
        $routine = new Routine();
        $this->assertEquals(true, $routine->getIsEnabled());
        $routine->setIsEnabled($isEnabled);
        $this->assertEquals($isEnabled, $routine->getIsEnabled());
        $this->assertIsBool($routine->getIsEnabled());
    }

    public function testSetIsEnabled(): void
    {
        $isEnabled = true;
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setIsEnabled($isEnabled));
        $this->assertEquals($isEnabled, $routine->getIsEnabled());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $routine = new Routine();
        $routine->setUser($user);
        $this->assertEquals($user, $routine->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setUser($user));
        $this->assertEquals($user, $routine->getUser());
    }

    public function testAddCompletedRoutine(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getCompletedRoutines());
        $completedRoutine1 = new CompletedRoutine();
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine1));
        $this->assertCount(1, $routine->getCompletedRoutines());
        $completedRoutine2 = new CompletedRoutine();
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine2));
        $this->assertCount(2, $routine->getCompletedRoutines());
        $deletedAt = new DateTimeImmutable();
        $completedRoutine2->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getCompletedRoutines());
    }

    public function testGetCompletedRoutines(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getCompletedRoutines());
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine));
        $this->assertCount(1, $routine->getCompletedRoutines());
    }

    public function testGetCompletedRoutinesAll(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getCompletedRoutinesAll());
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine));
        $this->assertCount(1, $routine->getCompletedRoutinesAll());
        $deletedAt = new DateTimeImmutable();
        $completedRoutine->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getCompletedRoutinesAll());
    }

    public function testGetCompletedRoutinesCount(): void
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(0, $routine->getCompletedRoutinesCount());
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine));
        $this->assertEquals(1, $routine->getCompletedRoutinesCount());
    }

    public function testGetCompletedRoutinesDevotedTime(): void
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals('0h 0m', $routine->getCompletedRoutinesDevotedTime());
        $minutesDevoted = 30;
        $completedRoutine->setMinutesDevoted($minutesDevoted);
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine));
        $this->assertEquals('0h '.$minutesDevoted.'m', $routine->getCompletedRoutinesDevotedTime());
    }

    public function testGetCompletedRoutinesPercent(): void
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(0, $routine->getCompletedRoutinesPercent());
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine));
        $this->assertEquals(0, $routine->getCompletedRoutinesPercent());
    }

    public function testRemoveCompletedRoutine(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getCompletedRoutines());
        $completedRoutine1 = new CompletedRoutine();
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine1));
        $this->assertCount(1, $routine->getCompletedRoutines());
        $completedRoutine2 = new CompletedRoutine();
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine2));
        $this->assertCount(2, $routine->getCompletedRoutines());
        $this->assertInstanceOf(Routine::class, $routine->removeCompletedRoutine($completedRoutine1));
    }

    public function testGetDescription(): void
    {
        $description = 'test description';
        $routine = new Routine();
        $this->assertEquals(null, $routine->getDescription());
        $routine->setDescription($description);
        $this->assertEquals($description, $routine->getDescription());
        $this->assertIsString($routine->getDescription());
    }

    public function testSetDescription(): void
    {
        $description = 'test description';
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setDescription($description));
        $this->assertEquals($description, $routine->getDescription());
    }

    public function testGetName(): void
    {
        $name = 'test name';
        $routine = new Routine();
        $this->assertEquals(null, $routine->getName());
        $routine->setName($name);
        $this->assertEquals($name, $routine->getName());
        $this->assertIsString($routine->getName());
    }

    public function testSetName(): void
    {
        $name = 'test name';
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setName($name));
        $this->assertEquals($name, $routine->getName());
    }

    public function testAddGoal(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getGoals());
        $goal1 = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal1));
        $this->assertCount(1, $routine->getGoals());
        $goal2 = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal2));
        $this->assertCount(2, $routine->getGoals());
        $deletedAt = new DateTimeImmutable();
        $goal2->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getGoals());
    }

    public function testGetGoals(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getGoals());
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertCount(1, $routine->getGoals());
    }

    public function testGetGoalsAll(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getGoalsAll());
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertCount(1, $routine->getGoalsAll());
        $deletedAt = new DateTimeImmutable();
        $goal->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getGoalsAll());
    }

    public function testGetGoalsCompleted(): void
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertCount(0, $routine->getGoalsCompleted());
        $goal->setIsCompleted(true);
        $this->assertCount(1, $routine->getGoalsCompleted());
    }

    public function testGetGoalsCompletedCount(): void
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertEquals(0, $routine->getGoalsCompletedCount());
        $goal->setIsCompleted(true);
        $this->assertEquals(1, $routine->getGoalsCompletedCount());
    }

    public function testGetGoalsCompletedPercent(): void
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertEquals(0, $routine->getGoalsCompletedPercent());
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertEquals(0, $routine->getGoalsCompletedPercent());
        $goal->setIsCompleted(true);
        $this->assertEquals(100, $routine->getGoalsCompletedPercent());
        $goal2 = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal2));
        $this->assertEquals(50, $routine->getGoalsCompletedPercent());
    }

    public function testGetGoalsNotCompleted(): void
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertCount(1, $routine->getGoalsNotCompleted());
        $goal->setIsCompleted(true);
        $this->assertCount(0, $routine->getGoalsNotCompleted());
    }

    public function testGetGoalsNotCompletedCount(): void
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertEquals(1, $routine->getGoalsNotCompletedCount());
        $goal->setIsCompleted(true);
        $this->assertEquals(0, $routine->getGoalsNotCompletedCount());
    }

    public function testGetGoalsNotCompletedPercent(): void
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertEquals(0, $routine->getGoalsNotCompletedPercent());
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertEquals(100, $routine->getGoalsNotCompletedPercent());
        $goal->setIsCompleted(true);
        $this->assertEquals(0, $routine->getGoalsNotCompletedPercent());
        $goal2 = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal2));
        $this->assertEquals(50, $routine->getGoalsNotCompletedPercent());
    }

    public function testRemoveGoal(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getGoals());
        $goal1 = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal1));
        $this->assertCount(1, $routine->getGoals());
        $goal2 = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal2));
        $this->assertCount(2, $routine->getGoals());
        $this->assertInstanceOf(Routine::class, $routine->removeGoal($goal1));
    }

    public function testAddNote(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getNotes());
        $note1 = new Note();
        $this->assertInstanceOf(Routine::class, $routine->addNote($note1));
        $this->assertCount(1, $routine->getNotes());
        $note2 = new Note();
        $this->assertInstanceOf(Routine::class, $routine->addNote($note2));
        $this->assertCount(2, $routine->getNotes());
        $deletedAt = new DateTimeImmutable();
        $note2->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getNotes());
    }

    public function testGetNotes(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getNotes());
        $note = new Note();
        $this->assertInstanceOf(Routine::class, $routine->addNote($note));
        $this->assertCount(1, $routine->getNotes());
    }

    public function testGetNotesAll(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getNotesAll());
        $note = new Note();
        $this->assertInstanceOf(Routine::class, $routine->addNote($note));
        $this->assertCount(1, $routine->getNotesAll());
        $deletedAt = new DateTimeImmutable();
        $note->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getNotesAll());
    }

    public function testRemoveNote(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getNotes());
        $note1 = new Note();
        $this->assertInstanceOf(Routine::class, $routine->addNote($note1));
        $this->assertCount(1, $routine->getNotes());
        $note2 = new Note();
        $this->assertInstanceOf(Routine::class, $routine->addNote($note2));
        $this->assertCount(2, $routine->getNotes());
        $this->assertInstanceOf(Routine::class, $routine->removeNote($note1));
    }

    public function testAddReminder(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getReminders());
        $reminder1 = new Reminder();
        $this->assertInstanceOf(Routine::class, $routine->addReminder($reminder1));
        $this->assertCount(1, $routine->getReminders());
        $reminder2 = new Reminder();
        $this->assertInstanceOf(Routine::class, $routine->addReminder($reminder2));
        $this->assertCount(2, $routine->getReminders());
        $deletedAt = new DateTimeImmutable();
        $reminder2->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getReminders());
    }

    public function testGetReminders(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getReminders());
        $reminder = new Reminder();
        $this->assertInstanceOf(Routine::class, $routine->addReminder($reminder));
        $this->assertCount(1, $routine->getReminders());
    }

    public function testGetRemindersAll(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getRemindersAll());
        $reminder = new Reminder();
        $this->assertInstanceOf(Routine::class, $routine->addReminder($reminder));
        $this->assertCount(1, $routine->getRemindersAll());
        $deletedAt = new DateTimeImmutable();
        $reminder->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getRemindersAll());
    }

    public function testRemoveReminder(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getReminders());
        $reminder1 = new Reminder();
        $this->assertInstanceOf(Routine::class, $routine->addReminder($reminder1));
        $this->assertCount(1, $routine->getReminders());
        $reminder2 = new Reminder();
        $this->assertInstanceOf(Routine::class, $routine->addReminder($reminder2));
        $this->assertCount(2, $routine->getReminders());
        $this->assertInstanceOf(Routine::class, $routine->removeReminder($reminder1));
    }

    public function testAddReward(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getRewards());
        $reward1 = new Reward();
        $this->assertInstanceOf(Routine::class, $routine->addReward($reward1));
        $this->assertCount(1, $routine->getRewards());
        $reward2 = new Reward();
        $this->assertInstanceOf(Routine::class, $routine->addReward($reward2));
        $this->assertCount(2, $routine->getRewards());
        $deletedAt = new DateTimeImmutable();
        $reward2->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getRewards());
    }

    public function testGetRewards(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getRewards());
        $reward = new Reward();
        $this->assertInstanceOf(Routine::class, $routine->addReward($reward));
        $this->assertCount(1, $routine->getRewards());
    }

    public function testGetRewardsAll(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getRewardsAll());
        $reward = new Reward();
        $this->assertInstanceOf(Routine::class, $routine->addReward($reward));
        $this->assertCount(1, $routine->getRewardsAll());
        $deletedAt = new DateTimeImmutable();
        $reward->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getRewardsAll());
    }

    public function testRemoveReward(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getRewards());
        $reward1 = new Reward();
        $this->assertInstanceOf(Routine::class, $routine->addReward($reward1));
        $this->assertCount(1, $routine->getRewards());
        $reward2 = new Reward();
        $this->assertInstanceOf(Routine::class, $routine->addReward($reward2));
        $this->assertCount(2, $routine->getRewards());
        $this->assertInstanceOf(Routine::class, $routine->removeReward($reward1));
    }

    public function testAddSentReminder(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getSentReminders());
        $sentReminder1 = new SentReminder();
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder1));
        $this->assertCount(1, $routine->getSentReminders());
        $sentReminder2 = new SentReminder();
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder2));
        $this->assertCount(2, $routine->getSentReminders());
        $deletedAt = new DateTimeImmutable();
        $sentReminder2->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getSentReminders());
    }

    public function testGetSentReminders(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getSentReminders());
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder));
        $this->assertCount(1, $routine->getSentReminders());
    }

    public function testGetSentRemindersAll(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getSentRemindersAll());
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder));
        $this->assertCount(1, $routine->getSentRemindersAll());
        $deletedAt = new DateTimeImmutable();
        $sentReminder->setDeletedAt($deletedAt);
        $this->assertCount(1, $routine->getSentRemindersAll());
    }

    public function testSetSentRemindersCount(): void
    {
        $routine = new Routine();
        $sentReminder = new SentReminder();
        $this->assertEquals(0, $routine->getSentRemindersCount());
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder));
        $this->assertEquals(1, $routine->getSentRemindersCount());
    }

    public function testGetSentRemindersPercent(): void
    {
        $routine = new Routine();
        $sentReminder = new SentReminder();
        $this->assertEquals(0, $routine->getSentRemindersPercent());
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder));
        $this->assertEquals(100, $routine->getSentRemindersPercent());
    }

    public function testRemoveSentReminder(): void
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getSentReminders());
        $sentReminder1 = new SentReminder();
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder1));
        $this->assertCount(1, $routine->getSentReminders());
        $sentReminder2 = new SentReminder();
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder2));
        $this->assertCount(2, $routine->getSentReminders());
        $this->assertInstanceOf(Routine::class, $routine->removeSentReminder($sentReminder1));
    }

    public function testGetType(): void
    {
        $type = Routine::TYPE_HOBBY;
        $routine = new Routine();
        $routine->setType($type);
        $this->assertEquals($type, $routine->getType());
        $this->assertIsString($routine->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(4, Routine::getTypeFormChoices());
        $this->assertIsArray(Routine::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(4, Routine::getTypeValidationChoices());
        $this->assertIsArray(Routine::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = Routine::TYPE_HOBBY;
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setType($type));
        $this->assertEquals($type, $routine->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setType($type));
    }
}
