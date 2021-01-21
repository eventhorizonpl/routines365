<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Answer;
use App\Entity\Questionnaire;
use App\Entity\User;
use App\Entity\UserQuestionnaire;
use App\Entity\UserQuestionnaireAnswer;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class UserQuestionnaireTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaire->setUuid($uuid);
        $this->assertEquals($uuid, $userQuestionnaire->__toString());
    }

    public function testGetId(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertEquals(null, $userQuestionnaire->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertEquals(null, $userQuestionnaire->getUuid());
        $userQuestionnaire->setUuid($uuid);
        $this->assertEquals($uuid, $userQuestionnaire->getUuid());
        $this->assertIsString($userQuestionnaire->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setUuid($uuid));
        $this->assertEquals($uuid, $userQuestionnaire->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertEquals(null, $userQuestionnaire->getCreatedBy());
        $userQuestionnaire->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $userQuestionnaire->getCreatedBy());
        $this->assertIsString($userQuestionnaire->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $userQuestionnaire->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertEquals(null, $userQuestionnaire->getDeletedBy());
        $userQuestionnaire->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $userQuestionnaire->getDeletedBy());
        $this->assertIsString($userQuestionnaire->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $userQuestionnaire->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertEquals(null, $userQuestionnaire->getUpdatedBy());
        $userQuestionnaire->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $userQuestionnaire->getUpdatedBy());
        $this->assertIsString($userQuestionnaire->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $userQuestionnaire->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertEquals(null, $userQuestionnaire->getCreatedAt());
        $userQuestionnaire->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $userQuestionnaire->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $userQuestionnaire->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertEquals(null, $userQuestionnaire->getDeletedAt());
        $userQuestionnaire->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $userQuestionnaire->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $userQuestionnaire->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertEquals(null, $userQuestionnaire->getUpdatedAt());
        $userQuestionnaire->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $userQuestionnaire->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $userQuestionnaire->getUpdatedAt());
    }

    public function testGetIsCompleted(): void
    {
        $isCompleted = true;
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertFalse($userQuestionnaire->getIsCompleted());
        $userQuestionnaire->setIsCompleted($isCompleted);
        $this->assertEquals($isCompleted, $userQuestionnaire->getIsCompleted());
        $this->assertIsBool($userQuestionnaire->getIsCompleted());
    }

    public function testSetIsCompleted(): void
    {
        $isCompleted = true;
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setIsCompleted($isCompleted));
        $this->assertEquals($isCompleted, $userQuestionnaire->getIsCompleted());
    }

    public function testGetIsRewarded(): void
    {
        $isRewarded = true;
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertFalse($userQuestionnaire->getIsRewarded());
        $userQuestionnaire->setIsRewarded($isRewarded);
        $this->assertEquals($isRewarded, $userQuestionnaire->getIsRewarded());
        $this->assertIsBool($userQuestionnaire->getIsRewarded());
    }

    public function testSetIsRewarded(): void
    {
        $isRewarded = true;
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setIsRewarded($isRewarded));
        $this->assertEquals($isRewarded, $userQuestionnaire->getIsRewarded());
    }

    public function testGetQuestionnaire(): void
    {
        $questionnaire = new Questionnaire();
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaire->setQuestionnaire($questionnaire);
        $this->assertEquals($questionnaire, $userQuestionnaire->getQuestionnaire());
    }

    public function testSetQuestionnaire(): void
    {
        $questionnaire = new Questionnaire();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setQuestionnaire($questionnaire));
        $this->assertEquals($questionnaire, $userQuestionnaire->getQuestionnaire());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaire->setUser($user);
        $this->assertEquals($user, $userQuestionnaire->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->setUser($user));
        $this->assertEquals($user, $userQuestionnaire->getUser());
    }

    public function testAddUserQuestionnaireAnswer(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertCount(0, $userQuestionnaire->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer1 = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->addUserQuestionnaireAnswer($userQuestionnaireAnswer1));
        $this->assertCount(1, $userQuestionnaire->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer2 = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->addUserQuestionnaireAnswer($userQuestionnaireAnswer2));
        $this->assertCount(2, $userQuestionnaire->getUserQuestionnaireAnswers());
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer2->setDeletedAt($deletedAt);
        $this->assertCount(1, $userQuestionnaire->getUserQuestionnaireAnswers());
    }

    public function testGetUserQuestionnaireAnswer(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $answer = new Answer();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->addUserQuestionnaireAnswer($userQuestionnaireAnswer));
        $this->assertEquals(null, $userQuestionnaire->getUserQuestionnaireAnswer($answer));
        $userQuestionnaireAnswer->setAnswer($answer);
        $this->assertEquals($userQuestionnaireAnswer, $userQuestionnaire->getUserQuestionnaireAnswer($answer));
    }

    public function testGetUserQuestionnaireAnswers(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertCount(0, $userQuestionnaire->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->addUserQuestionnaireAnswer($userQuestionnaireAnswer));
        $this->assertCount(1, $userQuestionnaire->getUserQuestionnaireAnswers());
    }

    public function testGetUserQuestionnaireAnswersAll(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertCount(0, $userQuestionnaire->getUserQuestionnaireAnswersAll());
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->addUserQuestionnaireAnswer($userQuestionnaireAnswer));
        $this->assertCount(1, $userQuestionnaire->getUserQuestionnaireAnswersAll());
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer->setDeletedAt($deletedAt);
        $this->assertCount(1, $userQuestionnaire->getUserQuestionnaireAnswersAll());
    }

    public function testHasUserQuestionnaireAnswer(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $answer = new Answer();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->addUserQuestionnaireAnswer($userQuestionnaireAnswer));
        $this->assertFalse($userQuestionnaire->hasUserQuestionnaireAnswer($answer));
        $userQuestionnaireAnswer->setAnswer($answer);
        $this->assertTrue($userQuestionnaire->hasUserQuestionnaireAnswer($answer));
    }

    public function testRemoveUserQuestionnaireAnswer(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertCount(0, $userQuestionnaire->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer1 = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->addUserQuestionnaireAnswer($userQuestionnaireAnswer1));
        $this->assertCount(1, $userQuestionnaire->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer2 = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->addUserQuestionnaireAnswer($userQuestionnaireAnswer2));
        $this->assertCount(2, $userQuestionnaire->getUserQuestionnaireAnswers());
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire->removeUserQuestionnaireAnswer($userQuestionnaireAnswer1));
    }
}
