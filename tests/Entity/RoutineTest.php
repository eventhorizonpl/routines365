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
use Symfony\Component\Uid\Uuid;

class RoutineTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine);
    }

    public function testToString()
    {
        $name = 'test name';
        $routine = new Routine();
        $routine->setName($name);
        $this->assertEquals($name, $routine->__toString());
    }

    public function testGetId()
    {
        $routine = new Routine();
        $this->assertEquals(null, $routine->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getUuid());
        $routine->setUuid($uuid);
        $this->assertEquals($uuid, $routine->getUuid());
        $this->assertIsString($routine->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setUuid($uuid));
        $this->assertEquals($uuid, $routine->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getCreatedBy());
        $routine->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $routine->getCreatedBy());
        $this->assertIsString($routine->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $routine->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getDeletedBy());
        $routine->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $routine->getDeletedBy());
        $this->assertIsString($routine->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $routine->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getUpdatedBy());
        $routine->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $routine->getUpdatedBy());
        $this->assertIsString($routine->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $routine->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getCreatedAt());
        $routine->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $routine->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $routine->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getDeletedAt());
        $routine->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $routine->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $routine->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertEquals(null, $routine->getUpdatedAt());
        $routine->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $routine->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $routine->getUpdatedAt());
    }

    public function testGetIsEnabled()
    {
        $isEnabled = true;
        $routine = new Routine();
        $this->assertEquals(true, $routine->getIsEnabled());
        $routine->setIsEnabled($isEnabled);
        $this->assertEquals($isEnabled, $routine->getIsEnabled());
        $this->assertIsBool($routine->getIsEnabled());
    }

    public function testSetIsEnabled()
    {
        $isEnabled = true;
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setIsEnabled($isEnabled));
        $this->assertEquals($isEnabled, $routine->getIsEnabled());
    }

    public function testGetUser()
    {
        $user = new User();
        $routine = new Routine();
        $routine->setUser($user);
        $this->assertEquals($user, $routine->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setUser($user));
        $this->assertEquals($user, $routine->getUser());
    }

    public function testAddCompletedRoutine()
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

    public function testGetCompletedRoutines()
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getCompletedRoutines());
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine));
        $this->assertCount(1, $routine->getCompletedRoutines());
    }

    public function testGetCompletedRoutinesAll()
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

    public function testGetCompletedRoutinesCount()
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(0, $routine->getCompletedRoutinesCount());
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine));
        $this->assertEquals(1, $routine->getCompletedRoutinesCount());
    }

    public function testGetCompletedRoutinesDevotedTime()
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals('0d 0h 0m', $routine->getCompletedRoutinesDevotedTime());
        $minutesDevoted = 30;
        $completedRoutine->setMinutesDevoted($minutesDevoted);
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine));
        $this->assertEquals('0d 0h '.$minutesDevoted.'m', $routine->getCompletedRoutinesDevotedTime());
    }

    public function testGetCompletedRoutinesPercent()
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(0, $routine->getCompletedRoutinesPercent());
        $this->assertInstanceOf(Routine::class, $routine->addCompletedRoutine($completedRoutine));
        $this->assertEquals(0, $routine->getCompletedRoutinesPercent());
    }

    public function testRemoveCompletedRoutine()
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

    public function testGetDescription()
    {
        $description = 'test description';
        $routine = new Routine();
        $this->assertEquals(null, $routine->getDescription());
        $routine->setDescription($description);
        $this->assertEquals($description, $routine->getDescription());
        $this->assertIsString($routine->getDescription());
    }

    public function testSetDescription()
    {
        $description = 'test description';
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setDescription($description));
        $this->assertEquals($description, $routine->getDescription());
    }

    public function testGetName()
    {
        $name = 'test name';
        $routine = new Routine();
        $this->assertEquals(null, $routine->getName());
        $routine->setName($name);
        $this->assertEquals($name, $routine->getName());
        $this->assertIsString($routine->getName());
    }

    public function testSetName()
    {
        $name = 'test name';
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setName($name));
        $this->assertEquals($name, $routine->getName());
    }

    public function testAddGoal()
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

    public function testGetGoals()
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getGoals());
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertCount(1, $routine->getGoals());
    }

    public function testGetGoalsAll()
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

    public function testGetGoalsCompleted()
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertCount(0, $routine->getGoalsCompleted());
        $goal->setIsCompleted(true);
        $this->assertCount(1, $routine->getGoalsCompleted());
    }

    public function testGetGoalsCompletedCount()
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertEquals(0, $routine->getGoalsCompletedCount());
        $goal->setIsCompleted(true);
        $this->assertEquals(1, $routine->getGoalsCompletedCount());
    }

    public function testGetGoalsCompletedPercent()
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

    public function testGetGoalsNotCompleted()
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertCount(1, $routine->getGoalsNotCompleted());
        $goal->setIsCompleted(true);
        $this->assertCount(0, $routine->getGoalsNotCompleted());
    }

    public function testGetGoalsNotCompletedCount()
    {
        $routine = new Routine();
        $goal = new Goal();
        $this->assertInstanceOf(Routine::class, $routine->addGoal($goal));
        $this->assertEquals(1, $routine->getGoalsNotCompletedCount());
        $goal->setIsCompleted(true);
        $this->assertEquals(0, $routine->getGoalsNotCompletedCount());
    }

    public function testGetGoalsNotCompletedPercent()
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

    public function testRemoveGoal()
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

    public function testAddNote()
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

    public function testGetNotes()
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getNotes());
        $note = new Note();
        $this->assertInstanceOf(Routine::class, $routine->addNote($note));
        $this->assertCount(1, $routine->getNotes());
    }

    public function testGetNotesAll()
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

    public function testRemoveNote()
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

    public function testAddReminder()
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

    public function testGetReminders()
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getReminders());
        $reminder = new Reminder();
        $this->assertInstanceOf(Routine::class, $routine->addReminder($reminder));
        $this->assertCount(1, $routine->getReminders());
    }

    public function testGetRemindersAll()
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

    public function testRemoveReminder()
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

    public function testAddReward()
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

    public function testGetRewards()
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getRewards());
        $reward = new Reward();
        $this->assertInstanceOf(Routine::class, $routine->addReward($reward));
        $this->assertCount(1, $routine->getRewards());
    }

    public function testGetRewardsAll()
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

    public function testRemoveReward()
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

    public function testAddSentReminder()
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

    public function testGetSentReminders()
    {
        $routine = new Routine();
        $this->assertCount(0, $routine->getSentReminders());
        $sentReminder = new SentReminder();
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder));
        $this->assertCount(1, $routine->getSentReminders());
    }

    public function testGetSentRemindersAll()
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

    public function testSetSentRemindersCount()
    {
        $routine = new Routine();
        $sentReminder = new SentReminder();
        $this->assertEquals(0, $routine->getSentRemindersCount());
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder));
        $this->assertEquals(1, $routine->getSentRemindersCount());
    }

    public function testGetSentRemindersPercent()
    {
        $routine = new Routine();
        $sentReminder = new SentReminder();
        $this->assertEquals(0, $routine->getSentRemindersPercent());
        $this->assertInstanceOf(Routine::class, $routine->addSentReminder($sentReminder));
        $this->assertEquals(100, $routine->getSentRemindersPercent());
    }

    public function testRemoveSentReminder()
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

    public function testGetType()
    {
        $type = Routine::TYPE_HOBBY;
        $routine = new Routine();
        $routine->setType($type);
        $this->assertEquals($type, $routine->getType());
        $this->assertIsString($routine->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(4, Routine::getTypeFormChoices());
        $this->assertIsArray(Routine::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(4, Routine::getTypeValidationChoices());
        $this->assertIsArray(Routine::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = Routine::TYPE_HOBBY;
        $routine = new Routine();
        $this->assertInstanceOf(Routine::class, $routine->setType($type));
        $this->assertEquals($type, $routine->getType());
    }
}
