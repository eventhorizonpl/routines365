<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Kpi;
use App\Factory\KpiFactory;
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
use App\Repository\QuestionRepository;
use App\Repository\QuestionnaireRepository;
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
use DateTimeImmutable;

class KpiService
{
    private AccountRepository $accountRepository;
    private AccountOperationRepository $accountOperationRepository;
    private AchievementRepository $achievementRepository;
    private AnswerRepository $answerRepository;
    private CompletedRoutineRepository $completedRoutineRepository;
    private ContactRepository $contactRepository;
    private GoalRepository $goalRepository;
    private KpiFactory $kpiFactory;
    private KpiManager $kpiManager;
    private NoteRepository $noteRepository;
    private ProfileRepository $profileRepository;
    private ProjectRepository $projectRepository;
    private PromotionRepository $promotionRepository;
    private QuestionRepository $questionRepository;
    private QuestionnaireRepository $questionnaireRepository;
    private QuoteRepository $quoteRepository;
    private ReminderMessageRepository $reminderMessageRepository;
    private ReminderRepository $reminderRepository;
    private RetentionRepository $retentionRepository;
    private RewardRepository $rewardRepository;
    private RoutineRepository $routineRepository;
    private SavedEmailRepository $savedEmailRepository;
    private SentReminderRepository $sentReminderRepository;
    private UserKpiRepository $userKpiRepository;
    private UserKytRepository $userKytRepository;
    private UserQuestionnaireAnswerRepository $userQuestionnaireAnswerRepository;
    private UserQuestionnaireRepository $userQuestionnaireRepository;
    private UserRepository $userRepository;

    public function __construct(
        AccountRepository $accountRepository,
        AccountOperationRepository $accountOperationRepository,
        AchievementRepository $achievementRepository,
        AnswerRepository $answerRepository,
        CompletedRoutineRepository $completedRoutineRepository,
        ContactRepository $contactRepository,
        GoalRepository $goalRepository,
        KpiFactory $kpiFactory,
        KpiManager $kpiManager,
        NoteRepository $noteRepository,
        ProfileRepository $profileRepository,
        ProjectRepository $projectRepository,
        PromotionRepository $promotionRepository,
        QuestionRepository $questionRepository,
        QuestionnaireRepository $questionnaireRepository,
        QuoteRepository $quoteRepository,
        ReminderMessageRepository $reminderMessageRepository,
        ReminderRepository $reminderRepository,
        RetentionRepository $retentionRepository,
        RewardRepository $rewardRepository,
        RoutineRepository $routineRepository,
        SavedEmailRepository $savedEmailRepository,
        SentReminderRepository $sentReminderRepository,
        UserKpiRepository $userKpiRepository,
        UserKytRepository $userKytRepository,
        UserQuestionnaireAnswerRepository $userQuestionnaireAnswerRepository,
        UserQuestionnaireRepository $userQuestionnaireRepository,
        UserRepository $userRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->accountOperationRepository = $accountOperationRepository;
        $this->achievementRepository = $achievementRepository;
        $this->answerRepository = $answerRepository;
        $this->completedRoutineRepository = $completedRoutineRepository;
        $this->contactRepository = $contactRepository;
        $this->goalRepository = $goalRepository;
        $this->kpiFactory = $kpiFactory;
        $this->kpiManager = $kpiManager;
        $this->noteRepository = $noteRepository;
        $this->profileRepository = $profileRepository;
        $this->projectRepository = $projectRepository;
        $this->promotionRepository = $promotionRepository;
        $this->questionRepository = $questionRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->quoteRepository = $quoteRepository;
        $this->reminderMessageRepository = $reminderMessageRepository;
        $this->reminderRepository = $reminderRepository;
        $this->retentionRepository = $retentionRepository;
        $this->rewardRepository = $rewardRepository;
        $this->routineRepository = $routineRepository;
        $this->savedEmailRepository = $savedEmailRepository;
        $this->sentReminderRepository = $sentReminderRepository;
        $this->userKpiRepository = $userKpiRepository;
        $this->userKytRepository = $userKytRepository;
        $this->userQuestionnaireAnswerRepository = $userQuestionnaireAnswerRepository;
        $this->userQuestionnaireRepository = $userQuestionnaireRepository;
        $this->userRepository = $userRepository;
    }

    public function create(): Kpi
    {
        $date = new DateTimeImmutable();
        $kpi = $this->kpiFactory->createKpiWithRequired(
            $this->accountRepository->count([]),
            $this->accountOperationRepository->count([]),
            $this->achievementRepository->count([]),
            $this->answerRepository->count([]),
            $this->completedRoutineRepository->count([]),
            $this->contactRepository->count([]),
            $date,
            $this->goalRepository->count([]),
            $this->noteRepository->count([]),
            $this->profileRepository->count([]),
            $this->projectRepository->count([]),
            $this->promotionRepository->count([]),
            $this->questionRepository->count([]),
            $this->questionnaireRepository->count([]),
            $this->quoteRepository->count([]),
            $this->reminderRepository->count([]),
            $this->reminderMessageRepository->count([]),
            $this->retentionRepository->count([]),
            $this->rewardRepository->count([]),
            $this->routineRepository->count([]),
            $this->savedEmailRepository->count([]),
            $this->sentReminderRepository->count([]),
            $this->userRepository->count([]),
            $this->userKpiRepository->count([]),
            $this->userKytRepository->count([]),
            $this->userQuestionnaireRepository->count([]),
            $this->userQuestionnaireAnswerRepository->count([])
        );
        $this->kpiManager->save($kpi);

        return $kpi;
    }
}
