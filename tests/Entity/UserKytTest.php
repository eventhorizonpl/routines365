<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\UserKyt;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class UserKytTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $userKyt->setUuid($uuid);
        $this->assertEquals($uuid, $userKyt->__toString());
    }

    public function testGetId(): void
    {
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getUuid());
        $userKyt->setUuid($uuid);
        $this->assertEquals($uuid, $userKyt->getUuid());
        $this->assertIsString($userKyt->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setUuid($uuid));
        $this->assertEquals($uuid, $userKyt->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getCreatedBy());
        $userKyt->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $userKyt->getCreatedBy());
        $this->assertIsString($userKyt->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $userKyt->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getDeletedBy());
        $userKyt->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $userKyt->getDeletedBy());
        $this->assertIsString($userKyt->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $userKyt->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getUpdatedBy());
        $userKyt->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $userKyt->getUpdatedBy());
        $this->assertIsString($userKyt->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $userKyt->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getCreatedAt());
        $userKyt->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $userKyt->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $userKyt->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getDeletedAt());
        $userKyt->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $userKyt->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $userKyt->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getUpdatedAt());
        $userKyt->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $userKyt->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $userKyt->getUpdatedAt());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $userKyt = new UserKyt();
        $userKyt->setUser($user);
        $this->assertEquals($user, $userKyt->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setUser($user));
        $this->assertEquals($user, $userKyt->getUser());
    }

    public function testGetBasicConfigurationLearned(): void
    {
        $basicConfigurationLearned = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getBasicConfigurationLearned());
        $userKyt->setBasicConfigurationLearned($basicConfigurationLearned);
        $this->assertEquals($basicConfigurationLearned, $userKyt->getBasicConfigurationLearned());
        $this->assertIsBool($userKyt->getBasicConfigurationLearned());
    }

    public function testSetBasicConfigurationLearned(): void
    {
        $basicConfigurationLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setBasicConfigurationLearned($basicConfigurationLearned));
        $this->assertEquals($basicConfigurationLearned, $userKyt->getBasicConfigurationLearned());
    }

    public function testGetBasicConfigurationSent(): void
    {
        $basicConfigurationSent = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getBasicConfigurationSent());
        $userKyt->setBasicConfigurationSent($basicConfigurationSent);
        $this->assertEquals($basicConfigurationSent, $userKyt->getBasicConfigurationSent());
        $this->assertIsBool($userKyt->getBasicConfigurationSent());
    }

    public function testSetBasicConfigurationSent(): void
    {
        $basicConfigurationSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setBasicConfigurationSent($basicConfigurationSent));
        $this->assertEquals($basicConfigurationSent, $userKyt->getBasicConfigurationSent());
    }

    public function testGetCompletingRoutinesLearned(): void
    {
        $completingRoutinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getCompletingRoutinesLearned());
        $userKyt->setCompletingRoutinesLearned($completingRoutinesLearned);
        $this->assertEquals($completingRoutinesLearned, $userKyt->getCompletingRoutinesLearned());
        $this->assertIsBool($userKyt->getCompletingRoutinesLearned());
    }

    public function testSetCompletingRoutinesLearned(): void
    {
        $completingRoutinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setCompletingRoutinesLearned($completingRoutinesLearned));
        $this->assertEquals($completingRoutinesLearned, $userKyt->getCompletingRoutinesLearned());
    }

    public function testGetCompletingRoutinesSent(): void
    {
        $completingRoutinesSent = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getCompletingRoutinesSent());
        $userKyt->setCompletingRoutinesSent($completingRoutinesSent);
        $this->assertEquals($completingRoutinesSent, $userKyt->getCompletingRoutinesSent());
        $this->assertIsBool($userKyt->getCompletingRoutinesSent());
    }

    public function testSetCompletingRoutinesSent(): void
    {
        $completingRoutinesSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setCompletingRoutinesSent($completingRoutinesSent));
        $this->assertEquals($completingRoutinesSent, $userKyt->getCompletingRoutinesSent());
    }

    public function testGetDateOfLastMessage(): void
    {
        $dateOfLastMessage = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getDateOfLastMessage());
        $userKyt->setDateOfLastMessage($dateOfLastMessage);
        $this->assertEquals($dateOfLastMessage, $userKyt->getDateOfLastMessage());
    }

    public function testSetDateOfLastMessage(): void
    {
        $dateOfLastMessage = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setDateOfLastMessage($dateOfLastMessage));
        $this->assertEquals($dateOfLastMessage, $userKyt->getDateOfLastMessage());
    }

    public function testGetGoalsLearned(): void
    {
        $goalsLearned = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getGoalsLearned());
        $userKyt->setGoalsLearned($goalsLearned);
        $this->assertEquals($goalsLearned, $userKyt->getGoalsLearned());
        $this->assertIsBool($userKyt->getGoalsLearned());
    }

    public function testSetGoalsLearned(): void
    {
        $goalsLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setGoalsLearned($goalsLearned));
        $this->assertEquals($goalsLearned, $userKyt->getGoalsLearned());
    }

    public function testGetGoalsSent(): void
    {
        $goalsSent = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getGoalsSent());
        $userKyt->setGoalsSent($goalsSent);
        $this->assertEquals($goalsSent, $userKyt->getGoalsSent());
        $this->assertIsBool($userKyt->getGoalsSent());
    }

    public function testSetGoalsSent(): void
    {
        $goalsSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setGoalsSent($goalsSent));
        $this->assertEquals($goalsSent, $userKyt->getGoalsSent());
    }

    public function testGetNotesLearned(): void
    {
        $notesLearned = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getNotesLearned());
        $userKyt->setNotesLearned($notesLearned);
        $this->assertEquals($notesLearned, $userKyt->getNotesLearned());
        $this->assertIsBool($userKyt->getNotesLearned());
    }

    public function testSetNotesLearned(): void
    {
        $notesLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setNotesLearned($notesLearned));
        $this->assertEquals($notesLearned, $userKyt->getNotesLearned());
    }

    public function testGetNotesSent(): void
    {
        $notesSent = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getNotesSent());
        $userKyt->setNotesSent($notesSent);
        $this->assertEquals($notesSent, $userKyt->getNotesSent());
        $this->assertIsBool($userKyt->getNotesSent());
    }

    public function testSetNotesSent(): void
    {
        $notesSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setNotesSent($notesSent));
        $this->assertEquals($notesSent, $userKyt->getNotesSent());
    }

    public function testGetProjectsLearned(): void
    {
        $projectsLearned = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getProjectsLearned());
        $userKyt->setProjectsLearned($projectsLearned);
        $this->assertEquals($projectsLearned, $userKyt->getProjectsLearned());
        $this->assertIsBool($userKyt->getProjectsLearned());
    }

    public function testSetProjectsLearned(): void
    {
        $projectsLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setProjectsLearned($projectsLearned));
        $this->assertEquals($projectsLearned, $userKyt->getProjectsLearned());
    }

    public function testGetProjectsSent(): void
    {
        $projectsSent = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getProjectsSent());
        $userKyt->setProjectsSent($projectsSent);
        $this->assertEquals($projectsSent, $userKyt->getProjectsSent());
        $this->assertIsBool($userKyt->getProjectsSent());
    }

    public function testSetProjectsSent(): void
    {
        $projectsSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setProjectsSent($projectsSent));
        $this->assertEquals($projectsSent, $userKyt->getProjectsSent());
    }

    public function testGetRemindersLearned(): void
    {
        $remindersLearned = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getRemindersLearned());
        $userKyt->setRemindersLearned($remindersLearned);
        $this->assertEquals($remindersLearned, $userKyt->getRemindersLearned());
        $this->assertIsBool($userKyt->getRemindersLearned());
    }

    public function testSetRemindersLearned(): void
    {
        $remindersLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRemindersLearned($remindersLearned));
        $this->assertEquals($remindersLearned, $userKyt->getRemindersLearned());
    }

    public function testGetRemindersSent(): void
    {
        $remindersSent = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getRemindersSent());
        $userKyt->setRemindersSent($remindersSent);
        $this->assertEquals($remindersSent, $userKyt->getRemindersSent());
        $this->assertIsBool($userKyt->getRemindersSent());
    }

    public function testSetRemindersSent(): void
    {
        $remindersSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRemindersSent($remindersSent));
        $this->assertEquals($remindersSent, $userKyt->getRemindersSent());
    }

    public function testGetRewardsLearned(): void
    {
        $routinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getRewardsLearned());
        $userKyt->setRewardsLearned($routinesLearned);
        $this->assertEquals($routinesLearned, $userKyt->getRewardsLearned());
        $this->assertIsBool($userKyt->getRewardsLearned());
    }

    public function testSetRewardsLearned(): void
    {
        $routinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRewardsLearned($routinesLearned));
        $this->assertEquals($routinesLearned, $userKyt->getRewardsLearned());
    }

    public function testGetRewardsSent(): void
    {
        $routinesSent = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getRewardsSent());
        $userKyt->setRewardsSent($routinesSent);
        $this->assertEquals($routinesSent, $userKyt->getRewardsSent());
        $this->assertIsBool($userKyt->getRewardsSent());
    }

    public function testSetRewardsSent(): void
    {
        $routinesSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRewardsSent($routinesSent));
        $this->assertEquals($routinesSent, $userKyt->getRewardsSent());
    }

    public function testGetRoutinesLearned(): void
    {
        $routinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getRoutinesLearned());
        $userKyt->setRoutinesLearned($routinesLearned);
        $this->assertEquals($routinesLearned, $userKyt->getRoutinesLearned());
        $this->assertIsBool($userKyt->getRoutinesLearned());
    }

    public function testSetRoutinesLearned(): void
    {
        $routinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRoutinesLearned($routinesLearned));
        $this->assertEquals($routinesLearned, $userKyt->getRoutinesLearned());
    }

    public function testGetRoutinesSent(): void
    {
        $routinesSent = true;
        $userKyt = new UserKyt();
        $this->assertEquals(null, $userKyt->getRoutinesSent());
        $userKyt->setRoutinesSent($routinesSent);
        $this->assertEquals($routinesSent, $userKyt->getRoutinesSent());
        $this->assertIsBool($userKyt->getRoutinesSent());
    }

    public function testSetRoutinesSent(): void
    {
        $routinesSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRoutinesSent($routinesSent));
        $this->assertEquals($routinesSent, $userKyt->getRoutinesSent());
    }
}
