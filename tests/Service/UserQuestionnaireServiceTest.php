<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Answer;
use App\Entity\Promotion;
use App\Entity\UserQuestionnaire;
use App\Factory\UserQuestionnaireFactory;
use App\Faker\PromotionFaker;
use App\Faker\QuestionnaireFaker;
use App\Faker\UserFaker;
use App\Faker\UserQuestionnaireFaker;
use App\Manager\UserQuestionnaireManager;
use App\Repository\UserQuestionnaireRepository;
use App\Service\PromotionService;
use App\Service\UserQuestionnaireAnswerService;
use App\Service\UserQuestionnaireService;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * @internal
 * @coversNothing
 */
final class UserQuestionnaireServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;
    /**
     * @inject
     */
    private ?PromotionService $promotionService;
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
    private ?UserQuestionnaireAnswerService $userQuestionnaireAnswerService;
    /**
     * @inject
     */
    private ?UserQuestionnaireFactory $userQuestionnaireFactory;
    /**
     * @inject
     */
    private ?UserQuestionnaireManager $userQuestionnaireManager;
    /**
     * @inject
     */
    private ?UserQuestionnaireRepository $userQuestionnaireRepository;
    /**
     * @inject
     */
    private ?UserQuestionnaireService $userQuestionnaireService;
    /**
     * @inject
     */
    private ?UserQuestionnaireFaker $userQuestionnaireFaker;

    protected function tearDown(): void
    {
        $this->promotionFaker = null;
        $this->promotionService = null;
        $this->questionnaireFaker = null;
        $this->userFaker = null;
        $this->userQuestionnaireAnswerService = null;
        $this->userQuestionnaireFactory = null;
        $this->userQuestionnaireManager = null;
        $this->userQuestionnaireRepository = null;
        $this->userQuestionnaireService = null;
        $this->userQuestionnaireFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $userQuestionnaireService = new UserQuestionnaireService(
            $this->promotionService,
            $this->userQuestionnaireAnswerService,
            $this->userQuestionnaireFactory,
            $this->userQuestionnaireManager,
            $this->userQuestionnaireRepository
        );

        $this->assertInstanceOf(UserQuestionnaireService::class, $userQuestionnaireService);
    }

    public function testFindOrCreate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();

        $userQuestionnaire = $this->userQuestionnaireService->findOrCreate(
            $questionnaire,
            $user
        );
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire);
        $this->assertSame($questionnaire, $userQuestionnaire->getQuestionnaire());
        $this->assertSame($user, $userQuestionnaire->getUser());
    }

    public function testUpdateUserQuestionnaire(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted(
            $user,
            $questionnaire,
            false
        );

        $questionnaire->getQuestions()->first()->getAnswers()->first()->setType(Answer::TYPE_OWN);
        $parameterBag = new ParameterBag([
            $questionnaire->getQuestions()->first()->getUuid() => $questionnaire->getQuestions()->first()->getAnswers()->first()->getUuid(),
        ]);

        $userQuestionnaire = $this->userQuestionnaireService->updateUserQuestionnaire($parameterBag, $questionnaire, $userQuestionnaire);
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire);
    }

    public function testRewardUserQuestionnaire(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $userQuestionnaire = $this->userQuestionnaireFaker->createUserQuestionnairePersisted(
            $user,
            $questionnaire,
            false
        );
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $userQuestionnaire = $this->userQuestionnaireService->rewardUserQuestionnaire($userQuestionnaire);
        $this->assertInstanceOf(UserQuestionnaire::class, $userQuestionnaire);
        $this->assertTrue($userQuestionnaire->getIsRewarded());
    }
}
