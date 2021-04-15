<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\{AccountOperationRepository, AccountRepository, AchievementRepository, AnswerRepository, CompletedRoutineRepository, ContactRepository, GoalRepository, KpiRepository, NoteRepository, ProfileRepository, ProjectRepository, PromotionRepository, QuestionRepository, QuestionnaireRepository, QuoteRepository, ReminderMessageRepository, ReminderRepository, RetentionRepository, RewardRepository, RoutineRepository, SavedEmailRepository, SentReminderRepository, TestimonialRepository, UserKpiRepository, UserKytRepository, UserQuestionnaireAnswerRepository, UserQuestionnaireRepository, UserRepository};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_ADMIN)]
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
