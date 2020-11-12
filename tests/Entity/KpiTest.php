<?php

namespace App\Tests\Entity;

use App\Entity\Kpi;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class KpiTest extends TestCase
{
    public function testConstruct()
    {
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi);
    }

    public function testToString()
    {
        $uuid = Uuid::v4();
        $kpi = new Kpi();
        $kpi->setUuid($uuid);
        $this->assertEquals($uuid, $kpi->__toString());
    }

    public function testGetId()
    {
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getId());
    }

    public function testGetUuid()
    {
        $uuid = Uuid::v4();
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getUuid());
        $kpi->setUuid($uuid);
        $this->assertEquals($uuid, $kpi->getUuid());
        $this->assertIsString($kpi->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = Uuid::v4();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUuid($uuid));
        $this->assertEquals($uuid, $kpi->getUuid());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getCreatedAt());
        $kpi->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $kpi->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $kpi->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getDeletedAt());
        $kpi->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $kpi->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $kpi->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getUpdatedAt());
        $kpi->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $kpi->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $kpi->getUpdatedAt());
    }

    public function testGetAccountCounter()
    {
        $accountCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getAccountCounter());
        $kpi->setAccountCounter($accountCounter);
        $this->assertEquals($accountCounter, $kpi->getAccountCounter());
        $this->assertIsInt($kpi->getAccountCounter());
    }

    public function testSetAccountCounter()
    {
        $accountCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setAccountCounter($accountCounter));
        $this->assertEquals($accountCounter, $kpi->getAccountCounter());
    }

    public function testGetAccountOperationCounter()
    {
        $accountOperationCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getAccountOperationCounter());
        $kpi->setAccountOperationCounter($accountOperationCounter);
        $this->assertEquals($accountOperationCounter, $kpi->getAccountOperationCounter());
        $this->assertIsInt($kpi->getAccountOperationCounter());
    }

    public function testSetAccountOperationCounter()
    {
        $accountOperationCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setAccountOperationCounter($accountOperationCounter));
        $this->assertEquals($accountOperationCounter, $kpi->getAccountOperationCounter());
    }

    public function testGetCompletedRoutineCounter()
    {
        $completedRoutineCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getCompletedRoutineCounter());
        $kpi->setCompletedRoutineCounter($completedRoutineCounter);
        $this->assertEquals($completedRoutineCounter, $kpi->getCompletedRoutineCounter());
        $this->assertIsInt($kpi->getCompletedRoutineCounter());
    }

    public function testSetCompletedRoutineCounter()
    {
        $completedRoutineCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setCompletedRoutineCounter($completedRoutineCounter));
        $this->assertEquals($completedRoutineCounter, $kpi->getCompletedRoutineCounter());
    }

    public function testGetContactCounter()
    {
        $contactCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getContactCounter());
        $kpi->setContactCounter($contactCounter);
        $this->assertEquals($contactCounter, $kpi->getContactCounter());
        $this->assertIsInt($kpi->getContactCounter());
    }

    public function testSetContactCounter()
    {
        $contactCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setContactCounter($contactCounter));
        $this->assertEquals($contactCounter, $kpi->getContactCounter());
    }

    public function testGetDate()
    {
        $date = new DateTimeImmutable();
        $kpi = new Kpi();
        $kpi->setDate($date);
        $this->assertEquals($date, $kpi->getDate());
    }

    public function testSetDate()
    {
        $date = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setDate($date));
        $this->assertEquals($date, $kpi->getDate());
    }

    public function testGetGoalCounter()
    {
        $goalCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getGoalCounter());
        $kpi->setGoalCounter($goalCounter);
        $this->assertEquals($goalCounter, $kpi->getGoalCounter());
        $this->assertIsInt($kpi->getGoalCounter());
    }

    public function testSetGoalCounter()
    {
        $goalCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setGoalCounter($goalCounter));
        $this->assertEquals($goalCounter, $kpi->getGoalCounter());
    }

    public function testGetNoteCounter()
    {
        $noteCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getNoteCounter());
        $kpi->setNoteCounter($noteCounter);
        $this->assertEquals($noteCounter, $kpi->getNoteCounter());
        $this->assertIsInt($kpi->getNoteCounter());
    }

    public function testSetNoteCounter()
    {
        $noteCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setNoteCounter($noteCounter));
        $this->assertEquals($noteCounter, $kpi->getNoteCounter());
    }

    public function testGetProfileCounter()
    {
        $profileCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getProfileCounter());
        $kpi->setProfileCounter($profileCounter);
        $this->assertEquals($profileCounter, $kpi->getProfileCounter());
        $this->assertIsInt($kpi->getProfileCounter());
    }

    public function testSetProfileCounter()
    {
        $profileCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setProfileCounter($profileCounter));
        $this->assertEquals($profileCounter, $kpi->getProfileCounter());
    }

    public function testGetProjectCounter()
    {
        $projectCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getProjectCounter());
        $kpi->setProjectCounter($projectCounter);
        $this->assertEquals($projectCounter, $kpi->getProjectCounter());
        $this->assertIsInt($kpi->getProjectCounter());
    }

    public function testSetProjectCounter()
    {
        $projectCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setProjectCounter($projectCounter));
        $this->assertEquals($projectCounter, $kpi->getProjectCounter());
    }

    public function testGetQuoteCounter()
    {
        $quoteCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getQuoteCounter());
        $kpi->setQuoteCounter($quoteCounter);
        $this->assertEquals($quoteCounter, $kpi->getQuoteCounter());
        $this->assertIsInt($kpi->getQuoteCounter());
    }

    public function testSetQuoteCounter()
    {
        $quoteCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setQuoteCounter($quoteCounter));
        $this->assertEquals($quoteCounter, $kpi->getQuoteCounter());
    }

    public function testGetReminderCounter()
    {
        $reminderCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getReminderCounter());
        $kpi->setReminderCounter($reminderCounter);
        $this->assertEquals($reminderCounter, $kpi->getReminderCounter());
        $this->assertIsInt($kpi->getReminderCounter());
    }

    public function testSetReminderCounter()
    {
        $reminderCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setReminderCounter($reminderCounter));
        $this->assertEquals($reminderCounter, $kpi->getReminderCounter());
    }

    public function testGetReminderMessageCounter()
    {
        $reminderMessageCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getReminderMessageCounter());
        $kpi->setReminderMessageCounter($reminderMessageCounter);
        $this->assertEquals($reminderMessageCounter, $kpi->getReminderMessageCounter());
        $this->assertIsInt($kpi->getReminderMessageCounter());
    }

    public function testSetReminderMessageCounter()
    {
        $reminderMessageCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setReminderMessageCounter($reminderMessageCounter));
        $this->assertEquals($reminderMessageCounter, $kpi->getReminderMessageCounter());
    }

    public function testGetRewardCounter()
    {
        $rewardCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getRewardCounter());
        $kpi->setRewardCounter($rewardCounter);
        $this->assertEquals($rewardCounter, $kpi->getRewardCounter());
        $this->assertIsInt($kpi->getRewardCounter());
    }

    public function testSetRewardCounter()
    {
        $rewardCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setRewardCounter($rewardCounter));
        $this->assertEquals($rewardCounter, $kpi->getRewardCounter());
    }

    public function testGetRoutineCounter()
    {
        $routineCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getRoutineCounter());
        $kpi->setRoutineCounter($routineCounter);
        $this->assertEquals($routineCounter, $kpi->getRoutineCounter());
        $this->assertIsInt($kpi->getRoutineCounter());
    }

    public function testSetRoutineCounter()
    {
        $routineCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setRoutineCounter($routineCounter));
        $this->assertEquals($routineCounter, $kpi->getRoutineCounter());
    }

    public function testGetSavedEmailCounter()
    {
        $savedEmailCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getSavedEmailCounter());
        $kpi->setSavedEmailCounter($savedEmailCounter);
        $this->assertEquals($savedEmailCounter, $kpi->getSavedEmailCounter());
        $this->assertIsInt($kpi->getSavedEmailCounter());
    }

    public function testSetSavedEmailCounter()
    {
        $savedEmailCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setSavedEmailCounter($savedEmailCounter));
        $this->assertEquals($savedEmailCounter, $kpi->getSavedEmailCounter());
    }

    public function testGetSentReminderCounter()
    {
        $sentReminderCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getSentReminderCounter());
        $kpi->setSentReminderCounter($sentReminderCounter);
        $this->assertEquals($sentReminderCounter, $kpi->getSentReminderCounter());
        $this->assertIsInt($kpi->getSentReminderCounter());
    }

    public function testSetSentReminderCounter()
    {
        $sentReminderCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setSentReminderCounter($sentReminderCounter));
        $this->assertEquals($sentReminderCounter, $kpi->getSentReminderCounter());
    }

    public function testGetUserCounter()
    {
        $userCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getUserCounter());
        $kpi->setUserCounter($userCounter);
        $this->assertEquals($userCounter, $kpi->getUserCounter());
        $this->assertIsInt($kpi->getUserCounter());
    }

    public function testSetUserCounter()
    {
        $userCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUserCounter($userCounter));
        $this->assertEquals($userCounter, $kpi->getUserCounter());
    }
}
