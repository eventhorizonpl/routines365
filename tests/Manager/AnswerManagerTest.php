<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Answer;
use App\Exception\ManagerException;
use App\Faker\AnswerFaker;
use App\Faker\QuestionnaireFaker;
use App\Faker\UserFaker;
use App\Manager\AnswerManager;
use App\Repository\AnswerRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AnswerManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AnswerManager $answerManager;
    /**
     * @inject
     */
    private ?AnswerFaker $answerFaker;
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?AnswerRepository $answerRepository;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        unset(
            $this->answerManager,
            $this->answerFaker,
            $this->answerManager,
            $this->questionnaireFaker,
            $this->answerRepository,
            $this->userFaker,
            $this->validator
        );

        parent::tearDown();
    }

    public function createAnswer(): Answer
    {
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $question = $questionnaire->getQuestions()->first();
        $answer = $this->answerFaker->createAnswer();
        $answer->setQuestion($question);

        return $answer;
    }

    public function createAnswerPersisted(): Answer
    {
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $answer = $questionnaire->getQuestions()->first()->getAnswers()->first();

        return $answer;
    }

    public function testConstruct(): void
    {
        $answerManager = new AnswerManager(
            $this->entityManager,
            $this->validator
        );

        $this->assertInstanceOf(AnswerManager::class, $answerManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $answer = $this->createAnswerPersisted();
        $answerUuid = $answer->getUuid();
        $answers = [];
        $answers[] = $answer;
        $answerManager = $this->answerManager->bulkSave($answers, (string) $user, 1);
        $this->assertInstanceOf(AnswerManager::class, $answerManager);

        $answer2 = $this->answerRepository->findOneByUuid($answerUuid);
        $this->assertInstanceOf(Answer::class, $answer2);
    }

    public function testDelete(): void
    {
        $this->purge();
        $answer = $this->createAnswerPersisted();
        $answerId = $answer->getId();

        $answerManager = $this->answerManager->delete($answer);
        $this->assertInstanceOf(AnswerManager::class, $answerManager);

        $answer2 = $this->answerRepository->findOneById($answerId);
        $this->assertNull($answer2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $answer = $this->createAnswer();

        $answerManager = $this->answerManager->save($answer, (string) $user, true);
        $this->assertInstanceOf(AnswerManager::class, $answerManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $answer = $this->createAnswer();
        $answer->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $answerManager = $this->answerManager->save($answer, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $answer = $this->createAnswerPersisted();
        $answerId = $answer->getId();

        $answerManager = $this->answerManager->softDelete($answer, (string) $user);
        $this->assertInstanceOf(AnswerManager::class, $answerManager);

        $answer2 = $this->answerRepository->findOneById($answerId);
        $this->assertInstanceOf(Answer::class, $answer2);
        $this->assertTrue(null !== $answer2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $answer = $this->createAnswerPersisted();
        $answerId = $answer->getId();

        $answerManager = $this->answerManager->softDelete($answer, (string) $user);
        $this->assertInstanceOf(AnswerManager::class, $answerManager);

        $answer2 = $this->answerRepository->findOneById($answerId);
        $this->assertInstanceOf(Answer::class, $answer2);
        $this->assertTrue(null !== $answer2->getDeletedAt());

        $answerManager = $this->answerManager->undelete($answer);
        $this->assertInstanceOf(AnswerManager::class, $answerManager);

        $answer3 = $this->answerRepository->findOneById($answerId);
        $this->assertInstanceOf(Answer::class, $answer3);
        $this->assertTrue(null === $answer3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $answer = $this->createAnswerPersisted();

        $errors = $this->answerManager->validate($answer);
        $this->assertCount(0, $errors);

        $answer->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->answerManager->validate($answer);
        $this->assertCount(1, $errors);
    }
}
