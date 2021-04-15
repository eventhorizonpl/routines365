<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{User, UserKyt};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 * @coversNothing
 */
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
        $this->assertSame($uuid, $userKyt->__toString());
    }

    public function testGetId(): void
    {
        $userKyt = new UserKyt();
        $this->assertNull($userKyt->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertNull($userKyt->getUuid());
        $userKyt->setUuid($uuid);
        $this->assertSame($uuid, $userKyt->getUuid());
        $this->assertIsString($userKyt->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setUuid($uuid));
        $this->assertSame($uuid, $userKyt->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertNull($userKyt->getCreatedBy());
        $userKyt->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $userKyt->getCreatedBy());
        $this->assertIsString($userKyt->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $userKyt->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertNull($userKyt->getDeletedBy());
        $userKyt->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $userKyt->getDeletedBy());
        $this->assertIsString($userKyt->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $userKyt->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertNull($userKyt->getUpdatedBy());
        $userKyt->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $userKyt->getUpdatedBy());
        $this->assertIsString($userKyt->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $userKyt->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertNull($userKyt->getCreatedAt());
        $userKyt->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $userKyt->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $userKyt->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertNull($userKyt->getDeletedAt());
        $userKyt->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $userKyt->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $userKyt->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertNull($userKyt->getUpdatedAt());
        $userKyt->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $userKyt->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $userKyt->getUpdatedAt());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $userKyt = new UserKyt();
        $userKyt->setUser($user);
        $this->assertSame($user, $userKyt->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setUser($user));
        $this->assertSame($user, $userKyt->getUser());
    }

    public function testGetBasicConfigurationLearned(): void
    {
        $basicConfigurationLearned = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getBasicConfigurationLearned());
        $userKyt->setBasicConfigurationLearned($basicConfigurationLearned);
        $this->assertSame($basicConfigurationLearned, $userKyt->getBasicConfigurationLearned());
        $this->assertIsBool($userKyt->getBasicConfigurationLearned());
    }

    public function testSetBasicConfigurationLearned(): void
    {
        $basicConfigurationLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setBasicConfigurationLearned($basicConfigurationLearned));
        $this->assertSame($basicConfigurationLearned, $userKyt->getBasicConfigurationLearned());
    }

    public function testGetBasicConfigurationSent(): void
    {
        $basicConfigurationSent = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getBasicConfigurationSent());
        $userKyt->setBasicConfigurationSent($basicConfigurationSent);
        $this->assertSame($basicConfigurationSent, $userKyt->getBasicConfigurationSent());
        $this->assertIsBool($userKyt->getBasicConfigurationSent());
    }

    public function testSetBasicConfigurationSent(): void
    {
        $basicConfigurationSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setBasicConfigurationSent($basicConfigurationSent));
        $this->assertSame($basicConfigurationSent, $userKyt->getBasicConfigurationSent());
    }

    public function testGetCompletingRoutinesLearned(): void
    {
        $completingRoutinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getCompletingRoutinesLearned());
        $userKyt->setCompletingRoutinesLearned($completingRoutinesLearned);
        $this->assertSame($completingRoutinesLearned, $userKyt->getCompletingRoutinesLearned());
        $this->assertIsBool($userKyt->getCompletingRoutinesLearned());
    }

    public function testSetCompletingRoutinesLearned(): void
    {
        $completingRoutinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setCompletingRoutinesLearned($completingRoutinesLearned));
        $this->assertSame($completingRoutinesLearned, $userKyt->getCompletingRoutinesLearned());
    }

    public function testGetCompletingRoutinesSent(): void
    {
        $completingRoutinesSent = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getCompletingRoutinesSent());
        $userKyt->setCompletingRoutinesSent($completingRoutinesSent);
        $this->assertSame($completingRoutinesSent, $userKyt->getCompletingRoutinesSent());
        $this->assertIsBool($userKyt->getCompletingRoutinesSent());
    }

    public function testSetCompletingRoutinesSent(): void
    {
        $completingRoutinesSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setCompletingRoutinesSent($completingRoutinesSent));
        $this->assertSame($completingRoutinesSent, $userKyt->getCompletingRoutinesSent());
    }

    public function testGetDateOfLastMessage(): void
    {
        $dateOfLastMessage = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertNull($userKyt->getDateOfLastMessage());
        $userKyt->setDateOfLastMessage($dateOfLastMessage);
        $this->assertSame($dateOfLastMessage, $userKyt->getDateOfLastMessage());
    }

    public function testSetDateOfLastMessage(): void
    {
        $dateOfLastMessage = new DateTimeImmutable();
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setDateOfLastMessage($dateOfLastMessage));
        $this->assertSame($dateOfLastMessage, $userKyt->getDateOfLastMessage());
    }

    public function testGetGoalsLearned(): void
    {
        $goalsLearned = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getGoalsLearned());
        $userKyt->setGoalsLearned($goalsLearned);
        $this->assertSame($goalsLearned, $userKyt->getGoalsLearned());
        $this->assertIsBool($userKyt->getGoalsLearned());
    }

    public function testSetGoalsLearned(): void
    {
        $goalsLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setGoalsLearned($goalsLearned));
        $this->assertSame($goalsLearned, $userKyt->getGoalsLearned());
    }

    public function testGetGoalsSent(): void
    {
        $goalsSent = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getGoalsSent());
        $userKyt->setGoalsSent($goalsSent);
        $this->assertSame($goalsSent, $userKyt->getGoalsSent());
        $this->assertIsBool($userKyt->getGoalsSent());
    }

    public function testSetGoalsSent(): void
    {
        $goalsSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setGoalsSent($goalsSent));
        $this->assertSame($goalsSent, $userKyt->getGoalsSent());
    }

    public function testGetNotesLearned(): void
    {
        $notesLearned = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getNotesLearned());
        $userKyt->setNotesLearned($notesLearned);
        $this->assertSame($notesLearned, $userKyt->getNotesLearned());
        $this->assertIsBool($userKyt->getNotesLearned());
    }

    public function testSetNotesLearned(): void
    {
        $notesLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setNotesLearned($notesLearned));
        $this->assertSame($notesLearned, $userKyt->getNotesLearned());
    }

    public function testGetNotesSent(): void
    {
        $notesSent = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getNotesSent());
        $userKyt->setNotesSent($notesSent);
        $this->assertSame($notesSent, $userKyt->getNotesSent());
        $this->assertIsBool($userKyt->getNotesSent());
    }

    public function testSetNotesSent(): void
    {
        $notesSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setNotesSent($notesSent));
        $this->assertSame($notesSent, $userKyt->getNotesSent());
    }

    public function testGetProjectsLearned(): void
    {
        $projectsLearned = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getProjectsLearned());
        $userKyt->setProjectsLearned($projectsLearned);
        $this->assertSame($projectsLearned, $userKyt->getProjectsLearned());
        $this->assertIsBool($userKyt->getProjectsLearned());
    }

    public function testSetProjectsLearned(): void
    {
        $projectsLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setProjectsLearned($projectsLearned));
        $this->assertSame($projectsLearned, $userKyt->getProjectsLearned());
    }

    public function testGetProjectsSent(): void
    {
        $projectsSent = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getProjectsSent());
        $userKyt->setProjectsSent($projectsSent);
        $this->assertSame($projectsSent, $userKyt->getProjectsSent());
        $this->assertIsBool($userKyt->getProjectsSent());
    }

    public function testSetProjectsSent(): void
    {
        $projectsSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setProjectsSent($projectsSent));
        $this->assertSame($projectsSent, $userKyt->getProjectsSent());
    }

    public function testGetRemindersLearned(): void
    {
        $remindersLearned = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getRemindersLearned());
        $userKyt->setRemindersLearned($remindersLearned);
        $this->assertSame($remindersLearned, $userKyt->getRemindersLearned());
        $this->assertIsBool($userKyt->getRemindersLearned());
    }

    public function testSetRemindersLearned(): void
    {
        $remindersLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRemindersLearned($remindersLearned));
        $this->assertSame($remindersLearned, $userKyt->getRemindersLearned());
    }

    public function testGetRemindersSent(): void
    {
        $remindersSent = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getRemindersSent());
        $userKyt->setRemindersSent($remindersSent);
        $this->assertSame($remindersSent, $userKyt->getRemindersSent());
        $this->assertIsBool($userKyt->getRemindersSent());
    }

    public function testSetRemindersSent(): void
    {
        $remindersSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRemindersSent($remindersSent));
        $this->assertSame($remindersSent, $userKyt->getRemindersSent());
    }

    public function testGetRewardsLearned(): void
    {
        $routinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getRewardsLearned());
        $userKyt->setRewardsLearned($routinesLearned);
        $this->assertSame($routinesLearned, $userKyt->getRewardsLearned());
        $this->assertIsBool($userKyt->getRewardsLearned());
    }

    public function testSetRewardsLearned(): void
    {
        $routinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRewardsLearned($routinesLearned));
        $this->assertSame($routinesLearned, $userKyt->getRewardsLearned());
    }

    public function testGetRewardsSent(): void
    {
        $routinesSent = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getRewardsSent());
        $userKyt->setRewardsSent($routinesSent);
        $this->assertSame($routinesSent, $userKyt->getRewardsSent());
        $this->assertIsBool($userKyt->getRewardsSent());
    }

    public function testSetRewardsSent(): void
    {
        $routinesSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRewardsSent($routinesSent));
        $this->assertSame($routinesSent, $userKyt->getRewardsSent());
    }

    public function testGetRoutinesLearned(): void
    {
        $routinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getRoutinesLearned());
        $userKyt->setRoutinesLearned($routinesLearned);
        $this->assertSame($routinesLearned, $userKyt->getRoutinesLearned());
        $this->assertIsBool($userKyt->getRoutinesLearned());
    }

    public function testSetRoutinesLearned(): void
    {
        $routinesLearned = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRoutinesLearned($routinesLearned));
        $this->assertSame($routinesLearned, $userKyt->getRoutinesLearned());
    }

    public function testGetRoutinesSent(): void
    {
        $routinesSent = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getRoutinesSent());
        $userKyt->setRoutinesSent($routinesSent);
        $this->assertSame($routinesSent, $userKyt->getRoutinesSent());
        $this->assertIsBool($userKyt->getRoutinesSent());
    }

    public function testSetRoutinesSent(): void
    {
        $routinesSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setRoutinesSent($routinesSent));
        $this->assertSame($routinesSent, $userKyt->getRoutinesSent());
    }

    public function testGetTestimonialRequestSent(): void
    {
        $testimonialRequestSent = true;
        $userKyt = new UserKyt();
        $this->assertFalse($userKyt->getTestimonialRequestSent());
        $userKyt->setTestimonialRequestSent($testimonialRequestSent);
        $this->assertSame($testimonialRequestSent, $userKyt->getTestimonialRequestSent());
        $this->assertIsBool($userKyt->getTestimonialRequestSent());
    }

    public function testSetTestimonialRequestSent(): void
    {
        $testimonialRequestSent = true;
        $userKyt = new UserKyt();
        $this->assertInstanceOf(UserKyt::class, $userKyt->setTestimonialRequestSent($testimonialRequestSent));
        $this->assertSame($testimonialRequestSent, $userKyt->getTestimonialRequestSent());
    }
}
