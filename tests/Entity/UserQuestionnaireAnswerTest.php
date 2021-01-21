<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Answer;
use App\Entity\UserQuestionnaire;
use App\Entity\UserQuestionnaireAnswer;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class UserQuestionnaireAnswerTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $userQuestionnaireAnswer->setUuid($uuid);
        $this->assertEquals($uuid, $userQuestionnaireAnswer->__toString());
    }

    public function testGetId(): void
    {
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertEquals(null, $userQuestionnaireAnswer->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertEquals(null, $userQuestionnaireAnswer->getUuid());
        $userQuestionnaireAnswer->setUuid($uuid);
        $this->assertEquals($uuid, $userQuestionnaireAnswer->getUuid());
        $this->assertIsString($userQuestionnaireAnswer->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setUuid($uuid));
        $this->assertEquals($uuid, $userQuestionnaireAnswer->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertEquals(null, $userQuestionnaireAnswer->getCreatedBy());
        $userQuestionnaireAnswer->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $userQuestionnaireAnswer->getCreatedBy());
        $this->assertIsString($userQuestionnaireAnswer->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $userQuestionnaireAnswer->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertEquals(null, $userQuestionnaireAnswer->getDeletedBy());
        $userQuestionnaireAnswer->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $userQuestionnaireAnswer->getDeletedBy());
        $this->assertIsString($userQuestionnaireAnswer->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $userQuestionnaireAnswer->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertEquals(null, $userQuestionnaireAnswer->getUpdatedBy());
        $userQuestionnaireAnswer->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $userQuestionnaireAnswer->getUpdatedBy());
        $this->assertIsString($userQuestionnaireAnswer->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $userQuestionnaireAnswer->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertEquals(null, $userQuestionnaireAnswer->getCreatedAt());
        $userQuestionnaireAnswer->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $userQuestionnaireAnswer->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $userQuestionnaireAnswer->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertEquals(null, $userQuestionnaireAnswer->getDeletedAt());
        $userQuestionnaireAnswer->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $userQuestionnaireAnswer->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $userQuestionnaireAnswer->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertEquals(null, $userQuestionnaireAnswer->getUpdatedAt());
        $userQuestionnaireAnswer->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $userQuestionnaireAnswer->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $userQuestionnaireAnswer->getUpdatedAt());
    }

    public function testGetContent(): void
    {
        $content = 'test content';
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertEquals(null, $userQuestionnaireAnswer->getContent());
        $userQuestionnaireAnswer->setContent($content);
        $this->assertEquals($content, $userQuestionnaireAnswer->getContent());
        $this->assertIsString($userQuestionnaireAnswer->getContent());
    }

    public function testSetContent(): void
    {
        $content = 'test content';
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setContent($content));
        $this->assertEquals($content, $userQuestionnaireAnswer->getContent());
    }

    public function testGetQuestionnaire(): void
    {
        $answer = new Answer();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $userQuestionnaireAnswer->setAnswer($answer);
        $this->assertEquals($answer, $userQuestionnaireAnswer->getAnswer());
    }

    public function testSetAnswer(): void
    {
        $answer = new Answer();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setAnswer($answer));
        $this->assertEquals($answer, $userQuestionnaireAnswer->getAnswer());
    }

    public function testGetUserQuestionnaire(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $userQuestionnaireAnswer->setUserQuestionnaire($userQuestionnaire);
        $this->assertEquals($userQuestionnaire, $userQuestionnaireAnswer->getUserQuestionnaire());
    }

    public function testSetUserQuestionnaire(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setUserQuestionnaire($userQuestionnaire));
        $this->assertEquals($userQuestionnaire, $userQuestionnaireAnswer->getUserQuestionnaire());
    }
}
