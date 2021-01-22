<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\UserQuestionnaire;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class QuestionnaireTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire);
    }

    public function testToString(): void
    {
        $title = 'test title';
        $questionnaire = new Questionnaire();
        $questionnaire->setTitle($title);
        $this->assertEquals($title, $questionnaire->__toString());
    }

    public function testGetId(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getUuid());
        $questionnaire->setUuid($uuid);
        $this->assertEquals($uuid, $questionnaire->getUuid());
        $this->assertIsString($questionnaire->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setUuid($uuid));
        $this->assertEquals($uuid, $questionnaire->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getCreatedBy());
        $questionnaire->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $questionnaire->getCreatedBy());
        $this->assertIsString($questionnaire->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $questionnaire->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getDeletedBy());
        $questionnaire->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $questionnaire->getDeletedBy());
        $this->assertIsString($questionnaire->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $questionnaire->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getUpdatedBy());
        $questionnaire->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $questionnaire->getUpdatedBy());
        $this->assertIsString($questionnaire->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $questionnaire->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getCreatedAt());
        $questionnaire->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $questionnaire->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $questionnaire->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getDeletedAt());
        $questionnaire->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $questionnaire->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $questionnaire->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getUpdatedAt());
        $questionnaire->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $questionnaire->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $questionnaire->getUpdatedAt());
    }

    public function testGetIsEnabled(): void
    {
        $isEnabled = true;
        $questionnaire = new Questionnaire();
        $this->assertFalse($questionnaire->getIsEnabled());
        $questionnaire->setIsEnabled($isEnabled);
        $this->assertEquals($isEnabled, $questionnaire->getIsEnabled());
        $this->assertIsBool($questionnaire->getIsEnabled());
    }

    public function testSetIsEnabled(): void
    {
        $isEnabled = true;
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setIsEnabled($isEnabled));
        $this->assertEquals($isEnabled, $questionnaire->getIsEnabled());
    }

    public function testGetDescription(): void
    {
        $description = 'test description';
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getDescription());
        $questionnaire->setDescription($description);
        $this->assertEquals($description, $questionnaire->getDescription());
        $this->assertIsString($questionnaire->getDescription());
    }

    public function testSetDescription(): void
    {
        $description = 'test description';
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setDescription($description));
        $this->assertEquals($description, $questionnaire->getDescription());
    }

    public function testAddQuestion(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertCount(0, $questionnaire->getQuestions());
        $question1 = new Question();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addQuestion($question1));
        $this->assertCount(1, $questionnaire->getQuestions());
        $question2 = new Question();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addQuestion($question2));
        $this->assertCount(2, $questionnaire->getQuestions());
        $deletedAt = new DateTimeImmutable();
        $question2->setDeletedAt($deletedAt);
        $this->assertCount(1, $questionnaire->getQuestions());
    }

    public function testGetQuestions(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertCount(0, $questionnaire->getQuestions());
        $question = new Question();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addQuestion($question));
        $this->assertCount(1, $questionnaire->getQuestions());
    }

    public function testGetQuestionsAll(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertCount(0, $questionnaire->getQuestionsAll());
        $question = new Question();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addQuestion($question));
        $this->assertCount(1, $questionnaire->getQuestionsAll());
        $deletedAt = new DateTimeImmutable();
        $question->setDeletedAt($deletedAt);
        $this->assertCount(1, $questionnaire->getQuestionsAll());
    }

    public function testRemoveQuestion(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertCount(0, $questionnaire->getQuestions());
        $question1 = new Question();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addQuestion($question1));
        $this->assertCount(1, $questionnaire->getQuestions());
        $question2 = new Question();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addQuestion($question2));
        $this->assertCount(2, $questionnaire->getQuestions());
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->removeQuestion($question1));
    }

    public function testGetTitle(): void
    {
        $title = 'test title';
        $questionnaire = new Questionnaire();
        $this->assertEquals(null, $questionnaire->getTitle());
        $questionnaire->setTitle($title);
        $this->assertEquals($title, $questionnaire->getTitle());
        $this->assertIsString($questionnaire->getTitle());
    }

    public function testSetTitle(): void
    {
        $title = 'test title';
        $questionnaire = new Questionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->setTitle($title));
        $this->assertEquals($title, $questionnaire->getTitle());
    }

    public function testAddUserQuestionnaire(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertCount(0, $questionnaire->getUserQuestionnaires());
        $userQuestionnaire1 = new UserQuestionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addUserQuestionnaire($userQuestionnaire1));
        $this->assertCount(1, $questionnaire->getUserQuestionnaires());
        $userQuestionnaire2 = new UserQuestionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addUserQuestionnaire($userQuestionnaire2));
        $this->assertCount(2, $questionnaire->getUserQuestionnaires());
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaire2->setDeletedAt($deletedAt);
        $this->assertCount(1, $questionnaire->getUserQuestionnaires());
    }

    public function testGetUserQuestionnaires(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertCount(0, $questionnaire->getUserQuestionnaires());
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addUserQuestionnaire($userQuestionnaire));
        $this->assertCount(1, $questionnaire->getUserQuestionnaires());
    }

    public function testGetUserQuestionnairesAll(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertCount(0, $questionnaire->getUserQuestionnairesAll());
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addUserQuestionnaire($userQuestionnaire));
        $this->assertCount(1, $questionnaire->getUserQuestionnairesAll());
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaire->setDeletedAt($deletedAt);
        $this->assertCount(1, $questionnaire->getUserQuestionnairesAll());
    }

    public function testRemoveUserQuestionnaire(): void
    {
        $questionnaire = new Questionnaire();
        $this->assertCount(0, $questionnaire->getUserQuestionnaires());
        $userQuestionnaire1 = new UserQuestionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addUserQuestionnaire($userQuestionnaire1));
        $this->assertCount(1, $questionnaire->getUserQuestionnaires());
        $userQuestionnaire2 = new UserQuestionnaire();
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->addUserQuestionnaire($userQuestionnaire2));
        $this->assertCount(2, $questionnaire->getUserQuestionnaires());
        $this->assertInstanceOf(Questionnaire::class, $questionnaire->removeUserQuestionnaire($userQuestionnaire1));
    }
}