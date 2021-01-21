<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Kpi;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class KpiTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $kpi = new Kpi();
        $kpi->setUuid($uuid);
        $this->assertEquals($uuid, $kpi->__toString());
    }

    public function testGetId(): void
    {
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getUuid());
        $kpi->setUuid($uuid);
        $this->assertEquals($uuid, $kpi->getUuid());
        $this->assertIsString($kpi->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUuid($uuid));
        $this->assertEquals($uuid, $kpi->getUuid());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getCreatedAt());
        $kpi->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $kpi->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $kpi->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getDeletedAt());
        $kpi->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $kpi->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $kpi->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertEquals(null, $kpi->getUpdatedAt());
        $kpi->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $kpi->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $kpi->getUpdatedAt());
    }

    public function testGetAccountCounter(): void
    {
        $accountCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getAccountCounter());
        $kpi->setAccountCounter($accountCounter);
        $this->assertEquals($accountCounter, $kpi->getAccountCounter());
        $this->assertIsInt($kpi->getAccountCounter());
    }

    public function testSetAccountCounter(): void
    {
        $accountCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setAccountCounter($accountCounter));
        $this->assertEquals($accountCounter, $kpi->getAccountCounter());
    }

    public function testGetAccountOperationCounter(): void
    {
        $accountOperationCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getAccountOperationCounter());
        $kpi->setAccountOperationCounter($accountOperationCounter);
        $this->assertEquals($accountOperationCounter, $kpi->getAccountOperationCounter());
        $this->assertIsInt($kpi->getAccountOperationCounter());
    }

    public function testSetAccountOperationCounter(): void
    {
        $accountOperationCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setAccountOperationCounter($accountOperationCounter));
        $this->assertEquals($accountOperationCounter, $kpi->getAccountOperationCounter());
    }

    public function testGetAchievementCounter(): void
    {
        $achievementCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getAchievementCounter());
        $kpi->setAchievementCounter($achievementCounter);
        $this->assertEquals($achievementCounter, $kpi->getAchievementCounter());
        $this->assertIsInt($kpi->getAchievementCounter());
    }

    public function testSetAchievementCounter(): void
    {
        $achievementCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setAchievementCounter($achievementCounter));
        $this->assertEquals($achievementCounter, $kpi->getAchievementCounter());
    }

    public function testGetAnswerCounter(): void
    {
        $answerCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getAnswerCounter());
        $kpi->setAnswerCounter($answerCounter);
        $this->assertEquals($answerCounter, $kpi->getAnswerCounter());
        $this->assertIsInt($kpi->getAnswerCounter());
    }

    public function testSetAnswerCounter(): void
    {
        $answerCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setAnswerCounter($answerCounter));
        $this->assertEquals($answerCounter, $kpi->getAnswerCounter());
    }

    public function testGetCompletedRoutineCounter(): void
    {
        $completedRoutineCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getCompletedRoutineCounter());
        $kpi->setCompletedRoutineCounter($completedRoutineCounter);
        $this->assertEquals($completedRoutineCounter, $kpi->getCompletedRoutineCounter());
        $this->assertIsInt($kpi->getCompletedRoutineCounter());
    }

    public function testSetCompletedRoutineCounter(): void
    {
        $completedRoutineCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setCompletedRoutineCounter($completedRoutineCounter));
        $this->assertEquals($completedRoutineCounter, $kpi->getCompletedRoutineCounter());
    }

    public function testGetContactCounter(): void
    {
        $contactCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getContactCounter());
        $kpi->setContactCounter($contactCounter);
        $this->assertEquals($contactCounter, $kpi->getContactCounter());
        $this->assertIsInt($kpi->getContactCounter());
    }

    public function testSetContactCounter(): void
    {
        $contactCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setContactCounter($contactCounter));
        $this->assertEquals($contactCounter, $kpi->getContactCounter());
    }

    public function testGetDate(): void
    {
        $date = new DateTimeImmutable();
        $kpi = new Kpi();
        $kpi->setDate($date);
        $this->assertEquals($date, $kpi->getDate());
    }

    public function testSetDate(): void
    {
        $date = new DateTimeImmutable();
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setDate($date));
        $this->assertEquals($date, $kpi->getDate());
    }

    public function testGetGoalCounter(): void
    {
        $goalCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getGoalCounter());
        $kpi->setGoalCounter($goalCounter);
        $this->assertEquals($goalCounter, $kpi->getGoalCounter());
        $this->assertIsInt($kpi->getGoalCounter());
    }

    public function testSetGoalCounter(): void
    {
        $goalCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setGoalCounter($goalCounter));
        $this->assertEquals($goalCounter, $kpi->getGoalCounter());
    }

    public function testGetNoteCounter(): void
    {
        $noteCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getNoteCounter());
        $kpi->setNoteCounter($noteCounter);
        $this->assertEquals($noteCounter, $kpi->getNoteCounter());
        $this->assertIsInt($kpi->getNoteCounter());
    }

    public function testSetNoteCounter(): void
    {
        $noteCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setNoteCounter($noteCounter));
        $this->assertEquals($noteCounter, $kpi->getNoteCounter());
    }

    public function testGetProfileCounter(): void
    {
        $profileCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getProfileCounter());
        $kpi->setProfileCounter($profileCounter);
        $this->assertEquals($profileCounter, $kpi->getProfileCounter());
        $this->assertIsInt($kpi->getProfileCounter());
    }

    public function testSetProfileCounter(): void
    {
        $profileCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setProfileCounter($profileCounter));
        $this->assertEquals($profileCounter, $kpi->getProfileCounter());
    }

    public function testGetProjectCounter(): void
    {
        $projectCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getProjectCounter());
        $kpi->setProjectCounter($projectCounter);
        $this->assertEquals($projectCounter, $kpi->getProjectCounter());
        $this->assertIsInt($kpi->getProjectCounter());
    }

    public function testSetProjectCounter(): void
    {
        $projectCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setProjectCounter($projectCounter));
        $this->assertEquals($projectCounter, $kpi->getProjectCounter());
    }

    public function testGetPromotionCounter(): void
    {
        $promotionCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getPromotionCounter());
        $kpi->setPromotionCounter($promotionCounter);
        $this->assertEquals($promotionCounter, $kpi->getPromotionCounter());
        $this->assertIsInt($kpi->getPromotionCounter());
    }

    public function testSetPromotionCounter(): void
    {
        $promotionCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setPromotionCounter($promotionCounter));
        $this->assertEquals($promotionCounter, $kpi->getPromotionCounter());
    }

    public function testGetQuestionCounter(): void
    {
        $questionCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getQuestionCounter());
        $kpi->setQuestionCounter($questionCounter);
        $this->assertEquals($questionCounter, $kpi->getQuestionCounter());
        $this->assertIsInt($kpi->getQuestionCounter());
    }

    public function testSetQuestionCounter(): void
    {
        $questionCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setQuestionCounter($questionCounter));
        $this->assertEquals($questionCounter, $kpi->getQuestionCounter());
    }

    public function testGetQuestionnaireCounter(): void
    {
        $questionnaireCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getQuestionnaireCounter());
        $kpi->setQuestionnaireCounter($questionnaireCounter);
        $this->assertEquals($questionnaireCounter, $kpi->getQuestionnaireCounter());
        $this->assertIsInt($kpi->getQuestionnaireCounter());
    }

    public function testSetQuestionnaireCounter(): void
    {
        $questionnaireCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setQuestionnaireCounter($questionnaireCounter));
        $this->assertEquals($questionnaireCounter, $kpi->getQuestionnaireCounter());
    }

    public function testGetQuoteCounter(): void
    {
        $quoteCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getQuoteCounter());
        $kpi->setQuoteCounter($quoteCounter);
        $this->assertEquals($quoteCounter, $kpi->getQuoteCounter());
        $this->assertIsInt($kpi->getQuoteCounter());
    }

    public function testSetQuoteCounter(): void
    {
        $quoteCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setQuoteCounter($quoteCounter));
        $this->assertEquals($quoteCounter, $kpi->getQuoteCounter());
    }

    public function testGetReminderCounter(): void
    {
        $reminderCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getReminderCounter());
        $kpi->setReminderCounter($reminderCounter);
        $this->assertEquals($reminderCounter, $kpi->getReminderCounter());
        $this->assertIsInt($kpi->getReminderCounter());
    }

    public function testSetReminderCounter(): void
    {
        $reminderCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setReminderCounter($reminderCounter));
        $this->assertEquals($reminderCounter, $kpi->getReminderCounter());
    }

    public function testGetReminderMessageCounter(): void
    {
        $reminderMessageCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getReminderMessageCounter());
        $kpi->setReminderMessageCounter($reminderMessageCounter);
        $this->assertEquals($reminderMessageCounter, $kpi->getReminderMessageCounter());
        $this->assertIsInt($kpi->getReminderMessageCounter());
    }

    public function testSetReminderMessageCounter(): void
    {
        $reminderMessageCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setReminderMessageCounter($reminderMessageCounter));
        $this->assertEquals($reminderMessageCounter, $kpi->getReminderMessageCounter());
    }

    public function testGetRetentionCounter(): void
    {
        $retentionCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getRetentionCounter());
        $kpi->setRetentionCounter($retentionCounter);
        $this->assertEquals($retentionCounter, $kpi->getRetentionCounter());
        $this->assertIsInt($kpi->getRetentionCounter());
    }

    public function testSetRetentionCounter(): void
    {
        $retentionCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setRetentionCounter($retentionCounter));
        $this->assertEquals($retentionCounter, $kpi->getRetentionCounter());
    }

    public function testGetRewardCounter(): void
    {
        $rewardCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getRewardCounter());
        $kpi->setRewardCounter($rewardCounter);
        $this->assertEquals($rewardCounter, $kpi->getRewardCounter());
        $this->assertIsInt($kpi->getRewardCounter());
    }

    public function testSetRewardCounter(): void
    {
        $rewardCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setRewardCounter($rewardCounter));
        $this->assertEquals($rewardCounter, $kpi->getRewardCounter());
    }

    public function testGetRoutineCounter(): void
    {
        $routineCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getRoutineCounter());
        $kpi->setRoutineCounter($routineCounter);
        $this->assertEquals($routineCounter, $kpi->getRoutineCounter());
        $this->assertIsInt($kpi->getRoutineCounter());
    }

    public function testSetRoutineCounter(): void
    {
        $routineCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setRoutineCounter($routineCounter));
        $this->assertEquals($routineCounter, $kpi->getRoutineCounter());
    }

    public function testGetSavedEmailCounter(): void
    {
        $savedEmailCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getSavedEmailCounter());
        $kpi->setSavedEmailCounter($savedEmailCounter);
        $this->assertEquals($savedEmailCounter, $kpi->getSavedEmailCounter());
        $this->assertIsInt($kpi->getSavedEmailCounter());
    }

    public function testSetSavedEmailCounter(): void
    {
        $savedEmailCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setSavedEmailCounter($savedEmailCounter));
        $this->assertEquals($savedEmailCounter, $kpi->getSavedEmailCounter());
    }

    public function testGetSentReminderCounter(): void
    {
        $sentReminderCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getSentReminderCounter());
        $kpi->setSentReminderCounter($sentReminderCounter);
        $this->assertEquals($sentReminderCounter, $kpi->getSentReminderCounter());
        $this->assertIsInt($kpi->getSentReminderCounter());
    }

    public function testSetSentReminderCounter(): void
    {
        $sentReminderCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setSentReminderCounter($sentReminderCounter));
        $this->assertEquals($sentReminderCounter, $kpi->getSentReminderCounter());
    }

    public function testGetUserCounter(): void
    {
        $userCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getUserCounter());
        $kpi->setUserCounter($userCounter);
        $this->assertEquals($userCounter, $kpi->getUserCounter());
        $this->assertIsInt($kpi->getUserCounter());
    }

    public function testSetUserCounter(): void
    {
        $userCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUserCounter($userCounter));
        $this->assertEquals($userCounter, $kpi->getUserCounter());
    }

    public function testGetUserKpiCounter(): void
    {
        $userKpiCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getUserKpiCounter());
        $kpi->setUserKpiCounter($userKpiCounter);
        $this->assertEquals($userKpiCounter, $kpi->getUserKpiCounter());
        $this->assertIsInt($kpi->getUserKpiCounter());
    }

    public function testSetUserKpiCounter(): void
    {
        $userKpiCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUserKpiCounter($userKpiCounter));
        $this->assertEquals($userKpiCounter, $kpi->getUserKpiCounter());
    }

    public function testGetUserKytCounter(): void
    {
        $userKytCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getUserKytCounter());
        $kpi->setUserKytCounter($userKytCounter);
        $this->assertEquals($userKytCounter, $kpi->getUserKytCounter());
        $this->assertIsInt($kpi->getUserKytCounter());
    }

    public function testSetUserKytCounter(): void
    {
        $userKytCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUserKytCounter($userKytCounter));
        $this->assertEquals($userKytCounter, $kpi->getUserKytCounter());
    }

    public function testGetUserQuestionnaireCounter(): void
    {
        $userQuestionnaireCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getUserQuestionnaireCounter());
        $kpi->setUserQuestionnaireCounter($userQuestionnaireCounter);
        $this->assertEquals($userQuestionnaireCounter, $kpi->getUserQuestionnaireCounter());
        $this->assertIsInt($kpi->getUserQuestionnaireCounter());
    }

    public function testSetUserQuestionnaireCounter(): void
    {
        $userQuestionnaireCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUserQuestionnaireCounter($userQuestionnaireCounter));
        $this->assertEquals($userQuestionnaireCounter, $kpi->getUserQuestionnaireCounter());
    }

    public function testGetUserQuestionnaireAnswerCounter(): void
    {
        $userQuestionnaireAnswerCounter = 10;
        $kpi = new Kpi();
        $this->assertEquals(0, $kpi->getUserQuestionnaireAnswerCounter());
        $kpi->setUserQuestionnaireAnswerCounter($userQuestionnaireAnswerCounter);
        $this->assertEquals($userQuestionnaireAnswerCounter, $kpi->getUserQuestionnaireAnswerCounter());
        $this->assertIsInt($kpi->getUserQuestionnaireAnswerCounter());
    }

    public function testSetUserQuestionnaireAnswerCounter(): void
    {
        $userQuestionnaireAnswerCounter = 10;
        $kpi = new Kpi();
        $this->assertInstanceOf(Kpi::class, $kpi->setUserQuestionnaireAnswerCounter($userQuestionnaireAnswerCounter));
        $this->assertEquals($userQuestionnaireAnswerCounter, $kpi->getUserQuestionnaireAnswerCounter());
    }
}
