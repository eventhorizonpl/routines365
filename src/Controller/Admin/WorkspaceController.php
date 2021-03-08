<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\AccountOperationRepository;
use App\Repository\AccountRepository;
use App\Repository\AchievementRepository;
use App\Repository\AnswerRepository;
use App\Repository\CompletedRoutineRepository;
use App\Repository\ContactRepository;
use App\Repository\GoalRepository;
use App\Repository\KpiRepository;
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
use App\Repository\TestimonialRepository;
use App\Repository\UserKpiRepository;
use App\Repository\UserKytRepository;
use App\Repository\UserQuestionnaireAnswerRepository;
use App\Repository\UserQuestionnaireRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class WorkspaceController extends AbstractController
{
    #[Route('/', name: 'workspace')]
    public function index(
        AccountRepository $accountRepository,
        AccountOperationRepository $accountOperationRepository,
        AchievementRepository $achievementRepository,
        AnswerRepository $answerRepository,
        CompletedRoutineRepository $completedRoutineRepository,
        ContactRepository $contactRepository,
        GoalRepository $goalRepository,
        NoteRepository $noteRepository,
        KpiRepository $kpiRepository,
        ProfileRepository $profileRepository,
        ProjectRepository $projectRepository,
        PromotionRepository $promotionRepository,
        QuestionnaireRepository $questionnaireRepository,
        QuestionRepository $questionRepository,
        QuoteRepository $quoteRepository,
        ReminderMessageRepository $reminderMessageRepository,
        ReminderRepository $reminderRepository,
        RetentionRepository $retentionRepository,
        RewardRepository $rewardRepository,
        RoutineRepository $routineRepository,
        SavedEmailRepository $savedEmailRepository,
        SentReminderRepository $sentReminderRepository,
        TestimonialRepository $testimonialRepository,
        UserKpiRepository $userKpiRepository,
        UserKytRepository $userKytRepository,
        UserQuestionnaireAnswerRepository $userQuestionnaireAnswerRepository,
        UserQuestionnaireRepository $userQuestionnaireRepository,
        UserRepository $userRepository
    ): Response {
        $accountsCount = $accountRepository->count([]);
        $accountOperationsCount = $accountOperationRepository->count([]);
        $achievementsCount = $achievementRepository->count([]);
        $answersCount = $answerRepository->count([]);
        $completedRoutinesCount = $completedRoutineRepository->count([]);
        $contactsCount = $contactRepository->count([]);
        $goalsCount = $goalRepository->count([]);
        $notesCount = $noteRepository->count([]);
        $kpisCount = $kpiRepository->count([]);
        $profilesCount = $profileRepository->count([]);
        $projectsCount = $projectRepository->count([]);
        $promotionsCount = $promotionRepository->count([]);
        $questionnairesCount = $questionnaireRepository->count([]);
        $questionsCount = $questionRepository->count([]);
        $quotesCount = $quoteRepository->count([]);
        $reminderMessagesCount = $reminderMessageRepository->count([]);
        $remindersCount = $reminderRepository->count([]);
        $retentionsCount = $retentionRepository->count([]);
        $rewardsCount = $rewardRepository->count([]);
        $routinesCount = $routineRepository->count([]);
        $savedEmailsCount = $savedEmailRepository->count([]);
        $sentRemindersCount = $sentReminderRepository->count([]);
        $testimonialsCount = $testimonialRepository->count([]);
        $userKpisCount = $userKpiRepository->count([]);
        $userKytsCount = $userKytRepository->count([]);
        $userQuestionnaireAnswersCount = $userQuestionnaireAnswerRepository->count([]);
        $userQuestionnairesCount = $userQuestionnaireRepository->count([]);
        $usersCount = $userRepository->count([]);

        return $this->render('admin/workspace/index.html.twig', [
            'accounts_count' => $accountsCount,
            'account_operations_count' => $accountOperationsCount,
            'achievements_count' => $achievementsCount,
            'answers_count' => $answersCount,
            'completed_routines_count' => $completedRoutinesCount,
            'contacts_count' => $contactsCount,
            'goals_count' => $goalsCount,
            'notes_count' => $notesCount,
            'kpis_count' => $kpisCount,
            'profiles_count' => $profilesCount,
            'projects_count' => $projectsCount,
            'promotions_count' => $promotionsCount,
            'questionnaires_count' => $questionnairesCount,
            'questions_count' => $questionsCount,
            'quotes_count' => $quotesCount,
            'reminder_messages_count' => $reminderMessagesCount,
            'reminders_count' => $remindersCount,
            'retentions_count' => $retentionsCount,
            'rewards_count' => $rewardsCount,
            'routines_count' => $routinesCount,
            'saved_emails_count' => $savedEmailsCount,
            'sent_reminders_count' => $sentRemindersCount,
            'testimonials_count' => $testimonialsCount,
            'user_kpis_count' => $userKpisCount,
            'user_kyts_count' => $userKytsCount,
            'user_questionnaire_answers_count' => $userQuestionnaireAnswersCount,
            'user_questionnaires_count' => $userQuestionnairesCount,
            'users_count' => $usersCount,
        ]);
    }
}
