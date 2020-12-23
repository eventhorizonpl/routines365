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
    public function testConstruct()
    {
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $userKpi = new UserKpi();
        $userKpi->setUuid($uuid);
        $this->assertEquals($uuid, $userKpi->__toString());
    }

    public function testGetId()
    {
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getUuid());
        $userKpi->setUuid($uuid);
        $this->assertEquals($uuid, $userKpi->getUuid());
        $this->assertIsString($userKpi->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setUuid($uuid));
        $this->assertEquals($uuid, $userKpi->getUuid());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getCreatedAt());
        $userKpi->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $userKpi->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $userKpi->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getDeletedAt());
        $userKpi->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $userKpi->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $userKpi->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertEquals(null, $userKpi->getUpdatedAt());
        $userKpi->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $userKpi->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $userKpi->getUpdatedAt());
    }

    public function testGetAccountOperationCounter()
    {
        $accountOperationCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getAccountOperationCounter());
        $userKpi->setAccountOperationCounter($accountOperationCounter);
        $this->assertEquals($accountOperationCounter, $userKpi->getAccountOperationCounter());
        $this->assertIsInt($userKpi->getAccountOperationCounter());
    }

    public function testSetAccountOperationCounter()
    {
        $accountOperationCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setAccountOperationCounter($accountOperationCounter));
        $this->assertEquals($accountOperationCounter, $userKpi->getAccountOperationCounter());
    }

    public function testGetAwardedRewardCounter()
    {
        $awardedRewardCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getAwardedRewardCounter());
        $userKpi->setAwardedRewardCounter($awardedRewardCounter);
        $this->assertEquals($awardedRewardCounter, $userKpi->getAwardedRewardCounter());
        $this->assertIsInt($userKpi->getAwardedRewardCounter());
    }

    public function testSetAwardedRewardCounter()
    {
        $awardedRewardCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setAwardedRewardCounter($awardedRewardCounter));
        $this->assertEquals($awardedRewardCounter, $userKpi->getAwardedRewardCounter());
    }

    public function testGetCompletedGoalCounter()
    {
        $completedGoalCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getCompletedGoalCounter());
        $userKpi->setCompletedGoalCounter($completedGoalCounter);
        $this->assertEquals($completedGoalCounter, $userKpi->getCompletedGoalCounter());
        $this->assertIsInt($userKpi->getCompletedGoalCounter());
    }

    public function testSetCompletedGoalCounter()
    {
        $completedGoalCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setCompletedGoalCounter($completedGoalCounter));
        $this->assertEquals($completedGoalCounter, $userKpi->getCompletedGoalCounter());
    }

    public function testGetCompletedProjectCounter()
    {
        $completedProjectCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getCompletedProjectCounter());
        $userKpi->setCompletedProjectCounter($completedProjectCounter);
        $this->assertEquals($completedProjectCounter, $userKpi->getCompletedProjectCounter());
        $this->assertIsInt($userKpi->getCompletedProjectCounter());
    }

    public function testSetCompletedProjectCounter()
    {
        $completedProjectCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setCompletedProjectCounter($completedProjectCounter));
        $this->assertEquals($completedProjectCounter, $userKpi->getCompletedProjectCounter());
    }

    public function testGetCompletedRoutineCounter()
    {
        $completedRoutineCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getCompletedRoutineCounter());
        $userKpi->setCompletedRoutineCounter($completedRoutineCounter);
        $this->assertEquals($completedRoutineCounter, $userKpi->getCompletedRoutineCounter());
        $this->assertIsInt($userKpi->getCompletedRoutineCounter());
    }

    public function testSetCompletedRoutineCounter()
    {
        $completedRoutineCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setCompletedRoutineCounter($completedRoutineCounter));
        $this->assertEquals($completedRoutineCounter, $userKpi->getCompletedRoutineCounter());
    }

    public function testGetContactCounter()
    {
        $contactCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getContactCounter());
        $userKpi->setContactCounter($contactCounter);
        $this->assertEquals($contactCounter, $userKpi->getContactCounter());
        $this->assertIsInt($userKpi->getContactCounter());
    }

    public function testSetContactCounter()
    {
        $contactCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setContactCounter($contactCounter));
        $this->assertEquals($contactCounter, $userKpi->getContactCounter());
    }

    public function testGetDate()
    {
        $date = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $userKpi->setDate($date);
        $this->assertEquals($date, $userKpi->getDate());
    }

    public function testSetDate()
    {
        $date = new DateTimeImmutable();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setDate($date));
        $this->assertEquals($date, $userKpi->getDate());
    }

    public function testGetGoalCounter()
    {
        $goalCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getGoalCounter());
        $userKpi->setGoalCounter($goalCounter);
        $this->assertEquals($goalCounter, $userKpi->getGoalCounter());
        $this->assertIsInt($userKpi->getGoalCounter());
    }

    public function testSetGoalCounter()
    {
        $goalCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setGoalCounter($goalCounter));
        $this->assertEquals($goalCounter, $userKpi->getGoalCounter());
    }

    public function testGetNextUserKpi()
    {
        $nextUserKpi = new UserKpi();
        $userKpi = new UserKpi();
        $userKpi->setNextUserKpi($nextUserKpi);
        $this->assertEquals($nextUserKpi, $userKpi->getNextUserKpi());
    }

    public function testSetNextUserKpi()
    {
        $nextUserKpi = new UserKpi();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setNextUserKpi($nextUserKpi));
        $this->assertEquals($nextUserKpi, $userKpi->getNextUserKpi());
    }

    public function testGetNoteCounter()
    {
        $noteCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getNoteCounter());
        $userKpi->setNoteCounter($noteCounter);
        $this->assertEquals($noteCounter, $userKpi->getNoteCounter());
        $this->assertIsInt($userKpi->getNoteCounter());
    }

    public function testSetNoteCounter()
    {
        $noteCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setNoteCounter($noteCounter));
        $this->assertEquals($noteCounter, $userKpi->getNoteCounter());
    }

    public function testGetPreviousUserKpi()
    {
        $previousUserKpi = new UserKpi();
        $userKpi = new UserKpi();
        $userKpi->setPreviousUserKpi($previousUserKpi);
        $this->assertEquals($previousUserKpi, $userKpi->getPreviousUserKpi());
    }

    public function testSetPreviousUserKpi()
    {
        $previousUserKpi = new UserKpi();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setPreviousUserKpi($previousUserKpi));
        $this->assertEquals($previousUserKpi, $userKpi->getPreviousUserKpi());
    }

    public function testGetProjectCounter()
    {
        $projectCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getProjectCounter());
        $userKpi->setProjectCounter($projectCounter);
        $this->assertEquals($projectCounter, $userKpi->getProjectCounter());
        $this->assertIsInt($userKpi->getProjectCounter());
    }

    public function testSetProjectCounter()
    {
        $projectCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setProjectCounter($projectCounter));
        $this->assertEquals($projectCounter, $userKpi->getProjectCounter());
    }

    public function testGetReminderCounter()
    {
        $reminderCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getReminderCounter());
        $userKpi->setReminderCounter($reminderCounter);
        $this->assertEquals($reminderCounter, $userKpi->getReminderCounter());
        $this->assertIsInt($userKpi->getReminderCounter());
    }

    public function testSetReminderCounter()
    {
        $reminderCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setReminderCounter($reminderCounter));
        $this->assertEquals($reminderCounter, $userKpi->getReminderCounter());
    }

    public function testGetRewardCounter()
    {
        $rewardCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getRewardCounter());
        $userKpi->setRewardCounter($rewardCounter);
        $this->assertEquals($rewardCounter, $userKpi->getRewardCounter());
        $this->assertIsInt($userKpi->getRewardCounter());
    }

    public function testSetRewardCounter()
    {
        $rewardCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setRewardCounter($rewardCounter));
        $this->assertEquals($rewardCounter, $userKpi->getRewardCounter());
    }

    public function testGetRoutineCounter()
    {
        $routineCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getRoutineCounter());
        $userKpi->setRoutineCounter($routineCounter);
        $this->assertEquals($routineCounter, $userKpi->getRoutineCounter());
        $this->assertIsInt($userKpi->getRoutineCounter());
    }

    public function testSetRoutineCounter()
    {
        $routineCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setRoutineCounter($routineCounter));
        $this->assertEquals($routineCounter, $userKpi->getRoutineCounter());
    }

    public function testGetSavedEmailCounter()
    {
        $savedEmailCounter = 10;
        $userKpi = new UserKpi();
        $this->assertEquals(0, $userKpi->getSavedEmailCounter());
        $userKpi->setSavedEmailCounter($savedEmailCounter);
        $this->assertEquals($savedEmailCounter, $userKpi->getSavedEmailCounter());
        $this->assertIsInt($userKpi->getSavedEmailCounter());
    }

    public function testSetSavedEmailCounter()
    {
        $savedEmailCounter = 10;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setSavedEmailCounter($savedEmailCounter));
        $this->assertEquals($savedEmailCounter, $userKpi->getSavedEmailCounter());
    }

    public function testGetType()
    {
        $type = UserKpi::TYPE_ANNUALLY;
        $userKpi = new UserKpi();
        $userKpi->setType($type);
        $this->assertEquals($type, $userKpi->getType());
        $this->assertIsString($userKpi->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(3, UserKpi::getTypeFormChoices());
        $this->assertIsArray(UserKpi::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(3, UserKpi::getTypeValidationChoices());
        $this->assertIsArray(UserKpi::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = UserKpi::TYPE_ANNUALLY;
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setType($type));
        $this->assertEquals($type, $userKpi->getType());
    }

    public function testSetTypeException()
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setType($type));
    }

    public function testGetUser()
    {
        $user = new User();
        $userKpi = new UserKpi();
        $userKpi->setUser($user);
        $this->assertEquals($user, $userKpi->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $userKpi = new UserKpi();
        $this->assertInstanceOf(UserKpi::class, $userKpi->setUser($user));
        $this->assertEquals($user, $userKpi->getUser());
    }
}
