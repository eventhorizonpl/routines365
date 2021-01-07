<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\UserKpi;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final class UserKpiTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $userKpi = new UserKpi();
        $userKpi->setUuid($uuid);
        $this->assertEquals($uuid, $userKpi->__toString());
    }

    public function testGetId(): void
    {
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getUuid());
        $userKpi->setUuid($uuid);
        $this->assertEquals($uuid, $userKpi->getUuid());
        $this->assertIsString($userKpi->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setUuid($uuid));
        $this->assertEquals($uuid, $userKpi->getUuid());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getCreatedAt());
        $userKpi->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $userKpi->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $userKpi->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getDeletedAt());
        $userKpi->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $userKpi->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $userKpi->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getUpdatedAt());
        $userKpi->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $userKpi->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $userKpi->getUpdatedAt());
    }

    public function testGetAccountOperationCounter(): void
    {
        $accountOperationCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getAccountOperationCounter());
        $userKpi->setAccountOperationCounter($accountOperationCounter);
        $this->assertEquals($accountOperationCounter, $userKpi->getAccountOperationCounter());
        $this->assertIsInt($userKpi->getAccountOperationCounter());
    }

    public function testSetAccountOperationCounter(): void
    {
        $accountOperationCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setAccountOperationCounter($accountOperationCounter));
        $this->assertEquals($accountOperationCounter, $userKpi->getAccountOperationCounter());
    }

    public function testGetAwardedRewardCounter(): void
    {
        $awardedRewardCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getAwardedRewardCounter());
        $userKpi->setAwardedRewardCounter($awardedRewardCounter);
        $this->assertEquals($awardedRewardCounter, $userKpi->getAwardedRewardCounter());
        $this->assertIsInt($userKpi->getAwardedRewardCounter());
    }

    public function testSetAwardedRewardCounter(): void
    {
        $awardedRewardCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setAwardedRewardCounter($awardedRewardCounter));
        $this->assertEquals($awardedRewardCounter, $userKpi->getAwardedRewardCounter());
    }

    public function testGetCompletedGoalCounter(): void
    {
        $completedGoalCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getCompletedGoalCounter());
        $userKpi->setCompletedGoalCounter($completedGoalCounter);
        $this->assertEquals($completedGoalCounter, $userKpi->getCompletedGoalCounter());
        $this->assertIsInt($userKpi->getCompletedGoalCounter());
    }

    public function testSetCompletedGoalCounter(): void
    {
        $completedGoalCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setCompletedGoalCounter($completedGoalCounter));
        $this->assertEquals($completedGoalCounter, $userKpi->getCompletedGoalCounter());
    }

    public function testGetCompletedProjectCounter(): void
    {
        $completedProjectCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getCompletedProjectCounter());
        $userKpi->setCompletedProjectCounter($completedProjectCounter);
        $this->assertEquals($completedProjectCounter, $userKpi->getCompletedProjectCounter());
        $this->assertIsInt($userKpi->getCompletedProjectCounter());
    }

    public function testSetCompletedProjectCounter(): void
    {
        $completedProjectCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setCompletedProjectCounter($completedProjectCounter));
        $this->assertEquals($completedProjectCounter, $userKpi->getCompletedProjectCounter());
    }

    public function testGetCompletedRoutineCounter(): void
    {
        $completedRoutineCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getCompletedRoutineCounter());
        $userKpi->setCompletedRoutineCounter($completedRoutineCounter);
        $this->assertEquals($completedRoutineCounter, $userKpi->getCompletedRoutineCounter());
        $this->assertIsInt($userKpi->getCompletedRoutineCounter());
    }

    public function testSetCompletedRoutineCounter(): void
    {
        $completedRoutineCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setCompletedRoutineCounter($completedRoutineCounter));
        $this->assertEquals($completedRoutineCounter, $userKpi->getCompletedRoutineCounter());
    }

    public function testGetContactCounter(): void
    {
        $contactCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getContactCounter());
        $userKpi->setContactCounter($contactCounter);
        $this->assertEquals($contactCounter, $userKpi->getContactCounter());
        $this->assertIsInt($userKpi->getContactCounter());
    }

    public function testSetContactCounter(): void
    {
        $contactCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setContactCounter($contactCounter));
        $this->assertEquals($contactCounter, $userKpi->getContactCounter());
    }

    public function testGetDate(): void
    {
        $date = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $userKpi->setDate($date);
        $this->assertEquals($date, $userKpi->getDate());
    }

    public function testSetDate(): void
    {
        $date = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setDate($date));
        $this->assertEquals($date, $userKpi->getDate());
    }

    public function testGetGoalCounter(): void
    {
        $goalCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getGoalCounter());
        $userKpi->setGoalCounter($goalCounter);
        $this->assertEquals($goalCounter, $userKpi->getGoalCounter());
        $this->assertIsInt($userKpi->getGoalCounter());
    }

    public function testSetGoalCounter(): void
    {
        $goalCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setGoalCounter($goalCounter));
        $this->assertEquals($goalCounter, $userKpi->getGoalCounter());
    }

    public function testGetNextUserKpi(): void
    {
        $nextUserKpi = new UserKpi();
        $userKpi = new UserKpi();
        $userKpi->setNextUserKpi($nextUserKpi);
        $this->assertEquals($nextUserKpi, $userKpi->getNextUserKpi());
    }

    public function testSetNextUserKpi(): void
    {
        $nextUserKpi = new UserKpi();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setNextUserKpi($nextUserKpi));
        $this->assertEquals($nextUserKpi, $userKpi->getNextUserKpi());
    }

    public function testGetNoteCounter(): void
    {
        $noteCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getNoteCounter());
        $userKpi->setNoteCounter($noteCounter);
        $this->assertEquals($noteCounter, $userKpi->getNoteCounter());
        $this->assertIsInt($userKpi->getNoteCounter());
    }

    public function testSetNoteCounter(): void
    {
        $noteCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setNoteCounter($noteCounter));
        $this->assertEquals($noteCounter, $userKpi->getNoteCounter());
    }

    public function testGetPreviousUserKpi(): void
    {
        $previousUserKpi = new UserKpi();
        $userKpi = new UserKpi();
        $userKpi->setPreviousUserKpi($previousUserKpi);
        $this->assertEquals($previousUserKpi, $userKpi->getPreviousUserKpi());
    }

    public function testSetPreviousUserKpi(): void
    {
        $previousUserKpi = new UserKpi();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setPreviousUserKpi($previousUserKpi));
        $this->assertEquals($previousUserKpi, $userKpi->getPreviousUserKpi());
    }

    public function testGetProjectCounter(): void
    {
        $projectCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getProjectCounter());
        $userKpi->setProjectCounter($projectCounter);
        $this->assertEquals($projectCounter, $userKpi->getProjectCounter());
        $this->assertIsInt($userKpi->getProjectCounter());
    }

    public function testSetProjectCounter(): void
    {
        $projectCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setProjectCounter($projectCounter));
        $this->assertEquals($projectCounter, $userKpi->getProjectCounter());
    }

    public function testGetReminderCounter(): void
    {
        $reminderCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getReminderCounter());
        $userKpi->setReminderCounter($reminderCounter);
        $this->assertEquals($reminderCounter, $userKpi->getReminderCounter());
        $this->assertIsInt($userKpi->getReminderCounter());
    }

    public function testSetReminderCounter(): void
    {
        $reminderCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setReminderCounter($reminderCounter));
        $this->assertEquals($reminderCounter, $userKpi->getReminderCounter());
    }

    public function testGetRewardCounter(): void
    {
        $rewardCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getRewardCounter());
        $userKpi->setRewardCounter($rewardCounter);
        $this->assertEquals($rewardCounter, $userKpi->getRewardCounter());
        $this->assertIsInt($userKpi->getRewardCounter());
    }

    public function testSetRewardCounter(): void
    {
        $rewardCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setRewardCounter($rewardCounter));
        $this->assertEquals($rewardCounter, $userKpi->getRewardCounter());
    }

    public function testGetRoutineCounter(): void
    {
        $routineCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getRoutineCounter());
        $userKpi->setRoutineCounter($routineCounter);
        $this->assertEquals($routineCounter, $userKpi->getRoutineCounter());
        $this->assertIsInt($userKpi->getRoutineCounter());
    }

    public function testSetRoutineCounter(): void
    {
        $routineCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setRoutineCounter($routineCounter));
        $this->assertEquals($routineCounter, $userKpi->getRoutineCounter());
    }

    public function testGetSavedEmailCounter(): void
    {
        $savedEmailCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getSavedEmailCounter());
        $userKpi->setSavedEmailCounter($savedEmailCounter);
        $this->assertEquals($savedEmailCounter, $userKpi->getSavedEmailCounter());
        $this->assertIsInt($userKpi->getSavedEmailCounter());
    }

    public function testSetSavedEmailCounter(): void
    {
        $savedEmailCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setSavedEmailCounter($savedEmailCounter));
        $this->assertEquals($savedEmailCounter, $userKpi->getSavedEmailCounter());
    }

    public function testGetType(): void
    {
        $type = UserKpi::TYPE_ANNUALLY;
        $userKpi = new UserKpi();
        $userKpi->setType($type);
        $this->assertEquals($type, $userKpi->getType());
        $this->assertIsString($userKpi->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(4, UserKpi::getTypeFormChoices());
        $this->assertIsArray(UserKpi::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(4, UserKpi::getTypeValidationChoices());
        $this->assertIsArray(UserKpi::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = UserKpi::TYPE_ANNUALLY;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setType($type));
        $this->assertEquals($type, $userKpi->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setType($type));
    }

    public function testGetUser(): void
    {
        $user = new User();
        $userKpi = new UserKpi();
        $userKpi->setUser($user);
        $this->assertEquals($user, $userKpi->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setUser($user));
        $this->assertEquals($user, $userKpi->getUser());
    }
}
