<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Kpi;
use App\Factory\KpiFactory;
use App\Manager\KpiManager;
use App\Repository\{AccountOperationRepository, AccountRepository, AchievementRepository, AnswerRepository, CompletedRoutineRepository, ContactRepository, GoalRepository, NoteRepository, ProfileRepository, ProjectRepository, PromotionRepository, QuestionRepository, QuestionnaireRepository, QuoteRepository, ReminderMessageRepository, ReminderRepository, RetentionRepository, RewardRepository, RoutineRepository, SavedEmailRepository, SentReminderRepository, UserKpiRepository, UserKytRepository, UserQuestionnaireAnswerRepository, UserQuestionnaireRepository, UserRepository};
use DateTimeImmutable;

class KpiService
{
    public function __construct(
        private AccountRepository $accountRepository,
        private AccountOperationRepository $accountOperationRepository,
        private AchievementRepository $achievementRepository,
        private AnswerRepository $answerRepository,
        private CompletedRoutineRepository $completedRoutineRepository,
        private ContactRepository $contactRepository,
        private GoalRepository $goalRepository,
        private KpiFactory $kpiFactory,
        private KpiManager $kpiManager,
        private NoteRepository $noteRepository,
        private ProfileRepository $profileRepository,
        private ProjectRepository $projectRepository,
        private PromotionRepository $promotionRepository,
        private QuestionRepository $questionRepository,
        private QuestionnaireRepository $questionnaireRepository,
        private QuoteRepository $quoteRepository,
        private ReminderMessageRepository $reminderMessageRepository,
        private ReminderRepository $reminderRepository,
        private RetentionRepository $retentionRepository,
        private RewardRepository $rewardRepository,
        private RoutineRepository $routineRepository,
        private SavedEmailRepository $savedEmailRepository,
        private SentReminderRepository $sentReminderRepository,
        private UserKpiRepository $userKpiRepository,
        private UserKytRepository $userKytRepository,
        private UserQuestionnaireAnswerRepository $userQuestionnaireAnswerRepository,
        private UserQuestionnaireRepository $userQuestionnaireRepository,
        private UserRepository $userRepository
    ) {
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
