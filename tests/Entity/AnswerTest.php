<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{Answer, Question, UserQuestionnaireAnswer};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
final class AnswerTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer);
    }

    public function testToString(): void
    {
        $content = 'test content';
        $answer = new Answer();
        $answer->setContent($content);
        $this->assertSame($content, $answer->__toString());
    }

    public function testGetId(): void
    {
        $answer = new Answer();
        $this->assertNull($answer->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $answer = new Answer();
        $this->assertNull($answer->getUuid());
        $answer->setUuid($uuid);
        $this->assertSame($uuid, $answer->getUuid());
        $this->assertIsString($answer->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setUuid($uuid));
        $this->assertSame($uuid, $answer->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $answer = new Answer();
        $this->assertNull($answer->getCreatedBy());
        $answer->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $answer->getCreatedBy());
        $this->assertIsString($answer->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $answer->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $answer = new Answer();
        $this->assertNull($answer->getDeletedBy());
        $answer->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $answer->getDeletedBy());
        $this->assertIsString($answer->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $answer->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $answer = new Answer();
        $this->assertNull($answer->getUpdatedBy());
        $answer->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $answer->getUpdatedBy());
        $this->assertIsString($answer->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $answer->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $answer = new Answer();
        $this->assertNull($answer->getCreatedAt());
        $answer->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $answer->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $answer->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $answer = new Answer();
        $this->assertNull($answer->getDeletedAt());
        $answer->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $answer->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $answer->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $answer = new Answer();
        $this->assertNull($answer->getUpdatedAt());
        $answer->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $answer->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $answer->getUpdatedAt());
    }

    public function testGetIsEnabled(): void
    {
        $isEnabled = true;
        $answer = new Answer();
        $this->assertTrue($answer->getIsEnabled());
        $answer->setIsEnabled($isEnabled);
        $this->assertSame($isEnabled, $answer->getIsEnabled());
        $this->assertIsBool($answer->getIsEnabled());
    }

    public function testSetIsEnabled(): void
    {
        $isEnabled = true;
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setIsEnabled($isEnabled));
        $this->assertSame($isEnabled, $answer->getIsEnabled());
    }

    public function testGetPosition(): void
    {
        $position = 10;
        $answer = new Answer();
        $this->assertSame(0, $answer->getPosition());
        $answer->setPosition($position);
        $this->assertSame($position, $answer->getPosition());
        $this->assertIsInt($answer->getPosition());
    }

    public function testSetPosition(): void
    {
        $position = 10;
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setPosition($position));
        $this->assertSame($position, $answer->getPosition());
    }

    public function testGetContent(): void
    {
        $content = 'test content';
        $answer = new Answer();
        $this->assertSame('', $answer->getContent());
        $answer->setContent($content);
        $this->assertSame($content, $answer->getContent());
        $this->assertIsString($answer->getContent());
    }

    public function testSetContent(): void
    {
        $content = 'test content';
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setContent($content));
        $this->assertSame($content, $answer->getContent());
    }

    public function testGetQuestion(): void
    {
        $question = new Question();
        $answer = new Answer();
        $answer->setQuestion($question);
        $this->assertSame($question, $answer->getQuestion());
    }

    public function testSetQuestion(): void
    {
        $question = new Question();
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setQuestion($question));
        $this->assertSame($question, $answer->getQuestion());
    }

    public function testGetType(): void
    {
        $type = Answer::TYPE_DEFINED;
        $answer = new Answer();
        $answer->setType($type);
        $this->assertSame($type, $answer->getType());
        $this->assertIsString($answer->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(2, Answer::getTypeFormChoices());
        $this->assertIsArray(Answer::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(2, Answer::getTypeValidationChoices());
        $this->assertIsArray(Answer::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = Answer::TYPE_DEFINED;
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setType($type));
        $this->assertSame($type, $answer->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $answer = new Answer();
        $this->assertInstanceOf(Answer::class, $answer->setType($type));
    }

    public function testAddUserQuestionnaireAnswer(): void
    {
        $answer = new Answer();
        $this->assertCount(0, $answer->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer1 = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(Answer::class, $answer->addUserQuestionnaireAnswer($userQuestionnaireAnswer1));
        $this->assertCount(1, $answer->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer2 = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(Answer::class, $answer->addUserQuestionnaireAnswer($userQuestionnaireAnswer2));
        $this->assertCount(2, $answer->getUserQuestionnaireAnswers());
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer2->setDeletedAt($deletedAt);
        $this->assertCount(1, $answer->getUserQuestionnaireAnswers());
    }

    public function testGetUserQuestionnaireAnswers(): void
    {
        $answer = new Answer();
        $this->assertCount(0, $answer->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(Answer::class, $answer->addUserQuestionnaireAnswer($userQuestionnaireAnswer));
        $this->assertCount(1, $answer->getUserQuestionnaireAnswers());
    }

    public function testGetUserQuestionnaireAnswersAll(): void
    {
        $answer = new Answer();
        $this->assertCount(0, $answer->getUserQuestionnaireAnswersAll());
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(Answer::class, $answer->addUserQuestionnaireAnswer($userQuestionnaireAnswer));
        $this->assertCount(1, $answer->getUserQuestionnaireAnswersAll());
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaireAnswer->setDeletedAt($deletedAt);
        $this->assertCount(1, $answer->getUserQuestionnaireAnswersAll());
    }

    public function testRemoveUserQuestionnaireAnswer(): void
    {
        $answer = new Answer();
        $this->assertCount(0, $answer->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer1 = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(Answer::class, $answer->addUserQuestionnaireAnswer($userQuestionnaireAnswer1));
        $this->assertCount(1, $answer->getUserQuestionnaireAnswers());
        $userQuestionnaireAnswer2 = new UserQuestionnaireAnswer();
        $this->assertInstanceOf(Answer::class, $answer->addUserQuestionnaireAnswer($userQuestionnaireAnswer2));
        $this->assertCount(2, $answer->getUserQuestionnaireAnswers());
        $this->assertInstanceOf(Answer::class, $answer->removeUserQuestionnaireAnswer($userQuestionnaireAnswer1));
    }
}
