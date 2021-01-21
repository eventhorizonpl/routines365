<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final class QuestionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question);
    }

    public function testToString(): void
    {
        $title = 'test title';
        $question = new Question();
        $question->setTitle($title);
        $this->assertEquals($title, $question->__toString());
    }

    public function testGetId(): void
    {
        $question = new Question();
        $this->assertEquals(null, $question->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $question = new Question();
        $this->assertEquals(null, $question->getUuid());
        $question->setUuid($uuid);
        $this->assertEquals($uuid, $question->getUuid());
        $this->assertIsString($question->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setUuid($uuid));
        $this->assertEquals($uuid, $question->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $question = new Question();
        $this->assertEquals(null, $question->getCreatedBy());
        $question->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $question->getCreatedBy());
        $this->assertIsString($question->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $question->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $question = new Question();
        $this->assertEquals(null, $question->getDeletedBy());
        $question->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $question->getDeletedBy());
        $this->assertIsString($question->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $question->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $question = new Question();
        $this->assertEquals(null, $question->getUpdatedBy());
        $question->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $question->getUpdatedBy());
        $this->assertIsString($question->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $question->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $question = new Question();
        $this->assertEquals(null, $question->getCreatedAt());
        $question->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $question->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $question->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $question = new Question();
        $this->assertEquals(null, $question->getDeletedAt());
        $question->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $question->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $question->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $question = new Question();
        $this->assertEquals(null, $question->getUpdatedAt());
        $question->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $question->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $question->getUpdatedAt());
    }

    public function testGetIsEnabled(): void
    {
        $isEnabled = true;
        $question = new Question();
        $this->assertTrue($question->getIsEnabled());
        $question->setIsEnabled($isEnabled);
        $this->assertEquals($isEnabled, $question->getIsEnabled());
        $this->assertIsBool($question->getIsEnabled());
    }

    public function testSetIsEnabled(): void
    {
        $isEnabled = true;
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setIsEnabled($isEnabled));
        $this->assertEquals($isEnabled, $question->getIsEnabled());
    }

    public function testGetPosition(): void
    {
        $position = 10;
        $question = new Question();
        $this->assertEquals(0, $question->getPosition());
        $question->setPosition($position);
        $this->assertEquals($position, $question->getPosition());
        $this->assertIsInt($question->getPosition());
    }

    public function testSetPosition(): void
    {
        $position = 10;
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setPosition($position));
        $this->assertEquals($position, $question->getPosition());
    }

    public function testAddAnswer(): void
    {
        $question = new Question();
        $this->assertCount(0, $question->getAnswers());
        $answer1 = new Answer();
        $this->assertInstanceOf(Question::class, $question->addAnswer($answer1));
        $this->assertCount(1, $question->getAnswers());
        $answer2 = new Answer();
        $this->assertInstanceOf(Question::class, $question->addAnswer($answer2));
        $this->assertCount(2, $question->getAnswers());
        $deletedAt = new DateTimeImmutable();
        $answer2->setDeletedAt($deletedAt);
        $this->assertCount(1, $question->getAnswers());
    }

    public function testGetAnswers(): void
    {
        $question = new Question();
        $this->assertCount(0, $question->getAnswers());
        $answer = new Answer();
        $this->assertInstanceOf(Question::class, $question->addAnswer($answer));
        $this->assertCount(1, $question->getAnswers());
    }

    public function testGetAnswersAll(): void
    {
        $question = new Question();
        $this->assertCount(0, $question->getAnswersAll());
        $answer = new Answer();
        $this->assertInstanceOf(Question::class, $question->addAnswer($answer));
        $this->assertCount(1, $question->getAnswersAll());
        $deletedAt = new DateTimeImmutable();
        $answer->setDeletedAt($deletedAt);
        $this->assertCount(1, $question->getAnswersAll());
    }

    public function testRemoveAnswer(): void
    {
        $question = new Question();
        $this->assertCount(0, $question->getAnswers());
        $answer1 = new Answer();
        $this->assertInstanceOf(Question::class, $question->addAnswer($answer1));
        $this->assertCount(1, $question->getAnswers());
        $answer2 = new Answer();
        $this->assertInstanceOf(Question::class, $question->addAnswer($answer2));
        $this->assertCount(2, $question->getAnswers());
        $this->assertInstanceOf(Question::class, $question->removeAnswer($answer1));
    }

    public function testGetQuestionnaire(): void
    {
        $questionnaire = new Questionnaire();
        $question = new Question();
        $question->setQuestionnaire($questionnaire);
        $this->assertEquals($questionnaire, $question->getQuestionnaire());
    }

    public function testSetQuestionnaire(): void
    {
        $questionnaire = new Questionnaire();
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setQuestionnaire($questionnaire));
        $this->assertEquals($questionnaire, $question->getQuestionnaire());
    }

    public function testGetTitle(): void
    {
        $title = 'test title';
        $question = new Question();
        $this->assertEquals(null, $question->getTitle());
        $question->setTitle($title);
        $this->assertEquals($title, $question->getTitle());
        $this->assertIsString($question->getTitle());
    }

    public function testSetTitle(): void
    {
        $title = 'test title';
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setTitle($title));
        $this->assertEquals($title, $question->getTitle());
    }

    public function testGetType(): void
    {
        $type = Question::TYPE_SINGLE_ANSWER;
        $question = new Question();
        $question->setType($type);
        $this->assertEquals($type, $question->getType());
        $this->assertIsString($question->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(2, Question::getTypeFormChoices());
        $this->assertIsArray(Question::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(2, Question::getTypeValidationChoices());
        $this->assertIsArray(Question::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = Question::TYPE_SINGLE_ANSWER;
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setType($type));
        $this->assertEquals($type, $question->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $question = new Question();
        $this->assertInstanceOf(Question::class, $question->setType($type));
    }
}
