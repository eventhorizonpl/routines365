<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Kpi;
use App\Factory\KpiFactory;
use App\Faker\UserFaker;
use App\Manager\KpiManager;
use App\Repository\AccountOperationRepository;
use App\Repository\AccountRepository;
use App\Repository\AchievementRepository;
use App\Repository\AnswerRepository;
use App\Repository\CompletedRoutineRepository;
use App\Repository\ContactRepository;
use App\Repository\GoalRepository;
use App\Repository\NoteRepository;
use App\Repository\ProfileRepository;
use App\Repository\ProjectRepository;
use App\Repository\PromotionRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionRepository;
use App\Repository\QuoteRepository;
use App\Repository\ReminderMessageRepository;
use App\Repository\ReminderRepository;
use App\Repository\RetentionRepository;
use App\Repository\RewardRepository;
use App\Repository\RoutineRepository;
use App\Repository\SavedEmailRepository;
use App\Repository\SentReminderRepository;
use App\Repository\UserKpiRepository;
use App\Repository\UserKytRepository;
use App\Repository\UserQuestionnaireAnswerRepository;
use App\Repository\UserQuestionnaireRepository;
use App\Repository\UserRepository;
use App\Service\KpiService;
use App\Tests\AbstractDoctrineTestCase;

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
        unset(
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
            $this->userRepository,
            $this->kpiService,
            $this->userFaker
        );

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
