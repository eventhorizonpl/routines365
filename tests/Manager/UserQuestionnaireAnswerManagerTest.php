<?php

declare(strict_types=1);

namespace App\Tests\Manager;

use App\Entity\UserQuestionnaireAnswer;
use App\Exception\ManagerException;
use App\Factory\UserQuestionnaireAnswerFactory;
use App\Faker\QuestionnaireFaker;
use App\Faker\UserFaker;
use App\Faker\UserQuestionnaireFaker;
use App\Manager\UserQuestionnaireAnswerManager;
use App\Repository\UserQuestionnaireAnswerRepository;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @internal
 * @coversNothing
 */
final class UserQuestionnaireAnswerManagerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserQuestionnaireAnswerFactory $userQuestionnaireAnswerFactory;
    /**
     * @inject
     */
    private ?UserQuestionnaireAnswerManager $userQuestionnaireAnswerManager;
    /**
     * @inject
     */
    private ?UserQuestionnaireAnswerRepository $userQuestionnaireAnswerRepository;
    /**
     * @inject
     */
    private ?UserQuestionnaireFaker $userQuestionnaireFaker;
    /**
     * @inject
     */
    private ?ValidatorInterface $validator;

    protected function tearDown(): void
    {
        $this->questionnaireFaker = null;
        $this->userFaker = null;
        $this->userQuestionnaireAnswerFactory = null;
        $this->userQuestionnaireAnswerManager = null;
        $this->userQuestionnaireAnswerRepository = null;
        $this->userQuestionnaireFaker = null;
        $this->validator = null
        ;

        parent::tearDown();
    }

    public function createUserQuestionnaireAnswer(): UserQuestionnaireAnswer
    {
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $answer = $questionnaire->getQuestions()->first()->getAnswers()->first();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted($user, $questionnaire);
        $userQuestionnaireAnswer = $this->userQuestionnaireAnswerFactory->createUserQuestionnaireAnswer();
        $userQuestionnaireAnswer->setAnswer($answer);
        $userQuestionnaireAnswer->setUserQuestionnaire($userQuestionnaire);

        return $userQuestionnaireAnswer;
    }

    public function testConstruct(): void
    {
        $userQuestionnaireAnswerManager = new UserQuestionnaireAnswerManager(
            $this->entityManager,
            $this->validator
        );

        $this->assertInstanceOf(UserQuestionnaireAnswerManager::class, $userQuestionnaireAnswerManager);
    }

    public function testBulkSave(): void
    {
        $this->purge();
        $userQuestionnaireAnswer = $this->createUserQuestionnaireAnswer();
        $user = $userQuestionnaireAnswer->getUserQuestionnaire()->getUser();
        $userQuestionnaireAnswerUuid = $userQuestionnaireAnswer->getUuid();
        $userQuestionnaireAnswers = [];
        $userQuestionnaireAnswers[] = $userQuestionnaireAnswer;
        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->bulkSave($userQuestionnaireAnswers, (string) $user, 1);
        $this->assertInstanceOf(UserQuestionnaireAnswerManager::class, $userQuestionnaireAnswerManager);

        $userQuestionnaireAnswer2 = $this->userQuestionnaireAnswerRepository->findOneByUuid($userQuestionnaireAnswerUuid);
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer2);
    }

    public function testDelete(): void
    {
        $this->purge();
        $userQuestionnaireAnswer = $this->createUserQuestionnaireAnswer();
        $user = $userQuestionnaireAnswer->getUserQuestionnaire()->getUser();
        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->save($userQuestionnaireAnswer, (string) $user, true);
        $userQuestionnaireAnswerId = $userQuestionnaireAnswer->getId();

        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->delete($userQuestionnaireAnswer);
        $this->assertInstanceOf(UserQuestionnaireAnswerManager::class, $userQuestionnaireAnswerManager);

        $userQuestionnaireAnswer2 = $this->userQuestionnaireAnswerRepository->findOneById($userQuestionnaireAnswerId);
        $this->assertNull($userQuestionnaireAnswer2);
    }

    public function testSave(): void
    {
        $this->purge();
        $userQuestionnaireAnswer = $this->createUserQuestionnaireAnswer();
        $user = $userQuestionnaireAnswer->getUserQuestionnaire()->getUser();

        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->save($userQuestionnaireAnswer, (string) $user, true);
        $this->assertInstanceOf(UserQuestionnaireAnswerManager::class, $userQuestionnaireAnswerManager);
    }

    public function testSaveException(): void
    {
        $this->expectException(ManagerException::class);
        $this->purge();
        $userQuestionnaireAnswer = $this->createUserQuestionnaireAnswer();
        $user = $userQuestionnaireAnswer->getUserQuestionnaire()->getUser();
        $userQuestionnaireAnswer->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');

        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->save($userQuestionnaireAnswer, (string) $user, true);
    }

    public function testSoftDelete(): void
    {
        $this->purge();
        $userQuestionnaireAnswer = $this->createUserQuestionnaireAnswer();
        $user = $userQuestionnaireAnswer->getUserQuestionnaire()->getUser();
        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->save($userQuestionnaireAnswer, (string) $user, true);
        $userQuestionnaireAnswerId = $userQuestionnaireAnswer->getId();

        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->softDelete($userQuestionnaireAnswer, (string) $user);
        $this->assertInstanceOf(UserQuestionnaireAnswerManager::class, $userQuestionnaireAnswerManager);

        $userQuestionnaireAnswer2 = $this->userQuestionnaireAnswerRepository->findOneById($userQuestionnaireAnswerId);
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer2);
        $this->assertTrue(null !== $userQuestionnaireAnswer2->getDeletedAt());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $userQuestionnaireAnswer = $this->createUserQuestionnaireAnswer();
        $user = $userQuestionnaireAnswer->getUserQuestionnaire()->getUser();
        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->save($userQuestionnaireAnswer, (string) $user, true);
        $userQuestionnaireAnswerId = $userQuestionnaireAnswer->getId();

        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->softDelete($userQuestionnaireAnswer, (string) $user);
        $this->assertInstanceOf(UserQuestionnaireAnswerManager::class, $userQuestionnaireAnswerManager);

        $userQuestionnaireAnswer2 = $this->userQuestionnaireAnswerRepository->findOneById($userQuestionnaireAnswerId);
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer2);
        $this->assertTrue(null !== $userQuestionnaireAnswer2->getDeletedAt());

        $userQuestionnaireAnswerManager = $this->userQuestionnaireAnswerManager->undelete($userQuestionnaireAnswer);
        $this->assertInstanceOf(UserQuestionnaireAnswerManager::class, $userQuestionnaireAnswerManager);

        $userQuestionnaireAnswer3 = $this->userQuestionnaireAnswerRepository->findOneById($userQuestionnaireAnswerId);
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer3);
        $this->assertTrue(null === $userQuestionnaireAnswer3->getDeletedAt());
    }

    public function testValidate(): void
    {
        $this->purge();
        $userQuestionnaireAnswer = $this->createUserQuestionnaireAnswer();

        $errors = $this->userQuestionnaireAnswerManager->validate($userQuestionnaireAnswer);
        $this->assertCount(4, $errors);
    }
}
