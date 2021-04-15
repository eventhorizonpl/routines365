<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\UserQuestionnaireAnswer;
use App\Factory\UserQuestionnaireAnswerFactory;
use App\Faker\{QuestionnaireFaker, UserFaker, UserQuestionnaireFaker};
use App\Manager\UserQuestionnaireAnswerManager;
use App\Repository\UserQuestionnaireAnswerRepository;
use App\Service\UserQuestionnaireAnswerService;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class UserQuestionnaireAnswerServiceTest extends AbstractDoctrineTestCase
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
    private ?UserQuestionnaireAnswerService $userQuestionnaireAnswerService;
    /**
     * @inject
     */
    private ?UserQuestionnaireFaker $userQuestionnaireFaker;

    protected function tearDown(): void
    {
        $this->questionnaireFaker = null;
        $this->userFaker = null;
        $this->userQuestionnaireAnswerFactory = null;
        $this->userQuestionnaireAnswerManager = null;
        $this->userQuestionnaireAnswerRepository = null;
        $this->userQuestionnaireAnswerService = null;
        $this->userQuestionnaireFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userQuestionnaireAnswerService = new UserQuestionnaireAnswerService(
            $this->userQuestionnaireAnswerFactory,
            $this->userQuestionnaireAnswerManager,
            $this->userQuestionnaireAnswerRepository
        );

        $this->assertInstanceOf(UserQuestionnaireAnswerService::class, $userQuestionnaireAnswerService);
    }

    public function testFindOrCreate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $answer = $questionnaire->getQuestions()->first()->getAnswers()->first();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted($user, $questionnaire);
        $content = 'test content';

        $userQuestionnaireAnswer = $this->userQuestionnaireAnswerService->findOrCreate(
            $answer,
            $userQuestionnaire,
            $content
        );
        $this->assertInstanceOf(UserQuestionnaireAnswer::class, $userQuestionnaireAnswer);
        $this->assertSame($answer, $userQuestionnaireAnswer->getAnswer());
        $this->assertSame($userQuestionnaire, $userQuestionnaireAnswer->getUserQuestionnaire());
        $this->assertSame($content, $userQuestionnaireAnswer->getContent());
    }
}
