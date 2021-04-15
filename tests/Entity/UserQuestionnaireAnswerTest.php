<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{Answer, UserQuestionnaire, UserQuestionnaireAnswer};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 * @coversNothing
 */
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
        $this->assertSame($uuid, $userQuestionnaireAnswer->__toString());
    }

    public function testGetId(): void
    {
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertNull($userQuestionnaireAnswer->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertNull($userQuestionnaireAnswer->getUuid());
        $userQuestionnaireAnswer->setUuid($uuid);
        $this->assertSame($uuid, $userQuestionnaireAnswer->getUuid());
        $this->assertIsString($userQuestionnaireAnswer->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setUuid($uuid));
        $this->assertSame($uuid, $userQuestionnaireAnswer->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertNull($userQuestionnaireAnswer->getCreatedBy());
        $userQuestionnaireAnswer->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $userQuestionnaireAnswer->getCreatedBy());
        $this->assertIsString($userQuestionnaireAnswer->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $userQuestionnaireAnswer->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertNull($userQuestionnaireAnswer->getDeletedBy());
        $userQuestionnaireAnswer->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $userQuestionnaireAnswer->getDeletedBy());
        $this->assertIsString($userQuestionnaireAnswer->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $userQuestionnaireAnswer->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertNull($userQuestionnaireAnswer->getUpdatedBy());
        $userQuestionnaireAnswer->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $userQuestionnaireAnswer->getUpdatedBy());
        $this->assertIsString($userQuestionnaireAnswer->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $userQuestionnaireAnswer->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertNull($userQuestionnaireAnswer->getCreatedAt());
        $userQuestionnaireAnswer->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $userQuestionnaireAnswer->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $userQuestionnaireAnswer->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertNull($userQuestionnaireAnswer->getDeletedAt());
        $userQuestionnaireAnswer->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $userQuestionnaireAnswer->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $userQuestionnaireAnswer->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertNull($userQuestionnaireAnswer->getUpdatedAt());
        $userQuestionnaireAnswer->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $userQuestionnaireAnswer->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $userQuestionnaireAnswer->getUpdatedAt());
    }

    public function testGetContent(): void
    {
        $content = 'test content';
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertNull($userQuestionnaireAnswer->getContent());
        $userQuestionnaireAnswer->setContent($content);
        $this->assertSame($content, $userQuestionnaireAnswer->getContent());
        $this->assertIsString($userQuestionnaireAnswer->getContent());
    }

    public function testSetContent(): void
    {
        $content = 'test content';
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setContent($content));
        $this->assertSame($content, $userQuestionnaireAnswer->getContent());
    }

    public function testGetQuestionnaire(): void
    {
        $answer = new Answer();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $userQuestionnaireAnswer->setAnswer($answer);
        $this->assertSame($answer, $userQuestionnaireAnswer->getAnswer());
    }

    public function testSetAnswer(): void
    {
        $answer = new Answer();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setAnswer($answer));
        $this->assertSame($answer, $userQuestionnaireAnswer->getAnswer());
    }

    public function testGetUserQuestionnaire(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $userQuestionnaireAnswer->setUserQuestionnaire($userQuestionnaire);
        $this->assertSame($userQuestionnaire, $userQuestionnaireAnswer->getUserQuestionnaire());
    }

    public function testSetUserQuestionnaire(): void
    {
        $userQuestionnaire = new UserQuestionnaire();
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer->setUserQuestionnaire($userQuestionnaire));
        $this->assertSame($userQuestionnaire, $userQuestionnaireAnswer->getUserQuestionnaire());
    }
}
