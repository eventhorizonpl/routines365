<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\Question;
use App\Exception\ManagerException;
use App\Faker\{QuestionFaker, QuestionnaireFaker, UserFaker};
use App\Manager\{AnswerManager, QuestionManager};
use App\Repository\QuestionRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 */
final class QuestionManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AnswerManager $answerManager;
    /**
     * @inject
     */
    private ?QuestionFaker $questionFaker;
    /**
     * @inject
     */
    private ?QuestionManager $questionManager;
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?QuestionRepository $questionRepository;
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
        $this->answerManager = null;
        $this->questionFaker = null;
        $this->questionManager = null;
        $this->questionnaireFaker = null;
        $this->questionRepository = null;
        $this->userFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function createQuestion(): Question
    {
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $question = $questionnaire->getQuestions()->first();
        $question->setQuestionnaire($questionnaire);

        return $question;
    }

    public function testConstruct(): void
    {
        $questionManager = new QuestionManager(
            $this->answerManager,
            $this->entityManager,
            $this->validator
        );

        $this->assertInstanceOf(QuestionManager::class, $questionManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $question = $this->createQuestion();
        $questionUuid = $question->getUuid();
        $questions = [];
        $questions[] = $question;
        $questionManager = $this->questionManager->bulkSave($questions, (string) $user, 1);
        $this->assertInstanceOf(QuestionManager::class, $questionManager);

        $question2 = $this->questionRepository->findOneByUuid($questionUuid);
        $this->assertInstanceOf(Question::class, $question2);
    }

    public function testDelete(): void
    {
        $this->purge();
        $question = $this->createQuestion();
        $questionId = $question->getId();

        $questionManager = $this->questionManager->delete($question);
        $this->assertInstanceOf(QuestionManager::class, $questionManager);

        $question2 = $this->questionRepository->findOneById($questionId);
        $this->assertNull($question2);
    }

    public function testSave(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $question = $this->createQuestion();

        $questionManager = $this->questionManager->save($question, (string) $user, true);
        $this->assertInstanceOf(QuestionManager::class, $questionManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $question = $this->createQuestion();
        $question->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $questionManager = $this->questionManager->save($question, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $question = $this->createQuestion();
        $questionId = $question->getId();

        $questionManager = $this->questionManager->softDelete($question, (string) $user);
        $this->assertInstanceOf(QuestionManager::class, $questionManager);

        $question2 = $this->questionRepository->findOneById($questionId);
        $this->assertInstanceOf(Question::class, $question2);
        $this->assertTrue(null !== $question2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $question = $this->createQuestion();
        $questionId = $question->getId();

        $questionManager = $this->questionManager->softDelete($question, (string) $user);
        $this->assertInstanceOf(QuestionManager::class, $questionManager);

        $question2 = $this->questionRepository->findOneById($questionId);
        $this->assertInstanceOf(Question::class, $question2);
        $this->assertTrue(null !== $question2->getDeletedAt());

        $questionManager = $this->questionManager->undelete($question);
        $this->assertInstanceOf(QuestionManager::class, $questionManager);

        $question3 = $this->questionRepository->findOneById($questionId);
        $this->assertInstanceOf(Question::class, $question3);
        $this->assertTrue(null === $question3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $question = $this->createQuestion();

        $errors = $this->questionManager->validate($question);
        $this->assertCount(0, $errors);

        $question->setTitle('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $errors = $this->questionManager->validate($question);
        $this->assertCount(1, $errors);
    }
}
