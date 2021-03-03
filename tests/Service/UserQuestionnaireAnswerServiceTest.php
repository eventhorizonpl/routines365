<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\UserQuestionnaireAnswer;
use App\Factory\UserQuestionnaireAnswerFactory;
use App\Faker\QuestionnaireFaker;
use App\Faker\UserFaker;
use App\Faker\UserQuestionnaireFaker;
use App\Manager\UserQuestionnaireAnswerManager;
use App\Repository\UserQuestionnaireAnswerRepository;
use App\Service\UserQuestionnaireAnswerService;
use App\Tests\AbstractDoctrineTestCase;

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
        unset(
            $this->questionnaireFaker,
            $this->userFaker,
            $this->userQuestionnaireAnswerFactory,
            $this->userQuestionnaireAnswerManager,
            $this->userQuestionnaireAnswerRepository,
            $this->userQuestionnaireAnswerService,
            $this->userQuestionnaireFaker
        );

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
        $this->assertEquals($answer, $userQuestionnaireAnswer->getAnswer());
        $this->assertEquals($userQuestionnaire, $userQuestionnaireAnswer->getUserQuestionnaire());
        $this->assertEquals($content, $userQuestionnaireAnswer->getContent());
    }
}
