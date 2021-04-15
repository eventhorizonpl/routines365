<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Kpi;
use App\Factory\KpiFactory;
use App\Faker\UserFaker;
use App\Manager\KpiManager;
use App\Repository\{AccountOperationRepository, AccountRepository, AchievementRepository, AnswerRepository, CompletedRoutineRepository, ContactRepository, GoalRepository, NoteRepository, ProfileRepository, ProjectRepository, PromotionRepository, QuestionRepository, QuestionnaireRepository, QuoteRepository, ReminderMessageRepository, ReminderRepository, RetentionRepository, RewardRepository, RoutineRepository, SavedEmailRepository, SentReminderRepository, UserKpiRepository, UserKytRepository, UserQuestionnaireAnswerRepository, UserQuestionnaireRepository, UserRepository};
use App\Service\KpiService;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 * @coversNothing
 */
final class KpiServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AccountRepository $accountRepository;
    /**
     * @inject
     */
    private ?AccountOperationRepository $accountOperationRepository;
    /**
     * @inject
     */
    private ?AchievementRepository $achievementRepository;
    /**
     * @inject
     */
    private ?AnswerRepository $answerRepository;
    /**
     * @inject
     */
    private ?CompletedRoutineRepository $completedRoutineRepository;
    /**
     * @inject
     */
    private ?ContactRepository $contactRepository;
    /**
     * @inject
     */
    private ?GoalRepository $goalRepository;
    /**
     * @inject
     */
    private ?KpiFactory $kpiFactory;
    /**
     * @inject
     */
    private ?KpiManager $kpiManager;
    /**
     * @inject
     */
    private ?NoteRepository $noteRepository;
    /**
     * @inject
     */
    private ?ProfileRepository $profileRepository;
    /**
     * @inject
     */
    private ?ProjectRepository $projectRepository;
    /**
     * @inject
     */
    private ?PromotionRepository $promotionRepository;
    /**
     * @inject
     */
    private ?QuestionRepository $questionRepository;
    /**
     * @inject
     */
    private ?QuestionnaireRepository $questionnaireRepository;
    /**
     * @inject
     */
    private ?QuoteRepository $quoteRepository;
    /**
     * @inject
     */
    private ?ReminderMessageRepository $reminderMessageRepository;
    /**
     * @inject
     */
    private ?ReminderRepository $reminderRepository;
    /**
     * @inject
     */
    private ?RetentionRepository $retentionRepository;
    /**
     * @inject
     */
    private ?RewardRepository $rewardRepository;
    /**
     * @inject
     */
    private ?RoutineRepository $routineRepository;
    /**
     * @inject
     */
    private ?SavedEmailRepository $savedEmailRepository;
    /**
     * @inject
     */
    private ?SentReminderRepository $sentReminderRepository;
    /**
     * @inject
     */
    private ?UserKpiRepository $userKpiRepository;
    /**
     * @inject
     */
    private ?UserKytRepository $userKytRepository;
    /**
     * @inject
     */
    private ?UserQuestionnaireAnswerRepository $userQuestionnaireAnswerRepository;
    /**
     * @inject
     */
    private ?UserQuestionnaireRepository $userQuestionnaireRepository;
    /**
     * @inject
     */
    private ?UserRepository $userRepository;
    /**
     * @inject
     */
    private ?KpiService $kpiService;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->accountRepository = null;
        $this->accountOperationRepository = null;
        $this->achievementRepository = null;
        $this->answerRepository = null;
        $this->completedRoutineRepository = null;
        $this->contactRepository = null;
        $this->goalRepository = null;
        $this->kpiFactory = null;
        $this->kpiManager = null;
        $this->noteRepository = null;
        $this->profileRepository = null;
        $this->projectRepository = null;
        $this->promotionRepository = null;
        $this->questionRepository = null;
        $this->questionnaireRepository = null;
        $this->quoteRepository = null;
        $this->reminderMessageRepository = null;
        $this->reminderRepository = null;
        $this->retentionRepository = null;
        $this->rewardRepository = null;
        $this->routineRepository = null;
        $this->savedEmailRepository = null;
        $this->sentReminderRepository = null;
        $this->userKpiRepository = null;
        $this->userKytRepository = null;
        $this->userQuestionnaireAnswerRepository = null;
        $this->userQuestionnaireRepository = null;
        $this->userRepository = null;
        $this->kpiService = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $kpiService = new KpiService(
            $this->accountRepository,
            $this->accountOperationRepository,
            $this->achievementRepository,
            $this->answerRepository,
            $this->completedRoutineRepository,
            $this->contactRepository,
            $this->goalRepository,
            $this->kpiFactory,
            $this->kpiManager,
            $this->noteRepository,
            $this->profileRepository,
            $this->projectRepository,
            $this->promotionRepository,
            $this->questionRepository,
            $this->questionnaireRepository,
            $this->quoteRepository,
            $this->reminderMessageRepository,
            $this->reminderRepository,
            $this->retentionRepository,
            $this->rewardRepository,
            $this->routineRepository,
            $this->savedEmailRepository,
            $this->sentReminderRepository,
            $this->userKpiRepository,
            $this->userKytRepository,
            $this->userQuestionnaireAnswerRepository,
            $this->userQuestionnaireRepository,
            $this->userRepository
        );

        $this->assertInstanceOf(KpiService::class, $kpiService);
    }

    public function testCreate(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $kpi = $this->kpiService->create();
        $this->assertInstanceOf(Kpi::class, $kpi);
    }
}
