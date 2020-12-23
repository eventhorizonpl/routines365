<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\AccountOperationRepository;
use App\Repository\AccountRepository;
use App\Repository\AchievementRepository;
use App\Repository\CompletedRoutineRepository;
use App\Repository\ContactRepository;
use App\Repository\GoalRepository;
use App\Repository\KpiRepository;
use App\Repository\NoteRepository;
use App\Repository\ProfileRepository;
use App\Repository\ProjectRepository;
use App\Repository\PromotionRepository;
use App\Repository\QuoteRepository;
use App\Repository\ReminderMessageRepository;
use App\Repository\ReminderRepository;
use App\Repository\RewardRepository;
use App\Repository\RoutineRepository;
use App\Repository\SavedEmailRepository;
use App\Repository\SentReminderRepository;
use App\Repository\UserKpiRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class WorkspaceController extends AbstractController
{
    /**
     * @Route("/", name="workspace")
     */
    public function index(
        AccountRepository $accountRepository,
        AccountOperationRepository $accountOperationRepository,
        AchievementRepository $achievementRepository,
        CompletedRoutineRepository $completedRoutineRepository,
        ContactRepository $contactRepository,
        GoalRepository $goalRepository,
        NoteRepository $noteRepository,
        KpiRepository $kpiRepository,
        ProfileRepository $profileRepository,
        ProjectRepository $projectRepository,
        PromotionRepository $promotionRepository,
        QuoteRepository $quoteRepository,
        ReminderMessageRepository $reminderMessageRepository,
        ReminderRepository $reminderRepository,
        RewardRepository $rewardRepository,
        RoutineRepository $routineRepository,
        SavedEmailRepository $savedEmailRepository,
        SentReminderRepository $sentReminderRepository,
        UserKpiRepository $userKpiRepository,
        UserRepository $userRepository
    ): Response {
        $accountsCount = $accountRepository->count([]);
        $accountOperationsCount = $accountOperationRepository->count([]);
        $achievementsCount = $achievementRepository->count([]);
        $completedRoutinesCount = $completedRoutineRepository->count([]);
        $contactsCount = $contactRepository->count([]);
        $goalsCount = $goalRepository->count([]);
        $notesCount = $noteRepository->count([]);
        $kpisCount = $kpiRepository->count([]);
        $profilesCount = $profileRepository->count([]);
        $projectsCount = $projectRepository->count([]);
        $promotionsCount = $promotionRepository->count([]);
        $quotesCount = $quoteRepository->count([]);
        $reminderMessagesCount = $reminderMessageRepository->count([]);
        $remindersCount = $reminderRepository->count([]);
        $rewardsCount = $rewardRepository->count([]);
        $routinesCount = $routineRepository->count([]);
        $savedEmailsCount = $savedEmailRepository->count([]);
        $sentRemindersCount = $sentReminderRepository->count([]);
        $userKpisCount = $userKpiRepository->count([]);
        $usersCount = $userRepository->count([]);

        return $this->render('admin/workspace/index.html.twig', [
            'accounts_count' => $accountsCount,
            'account_operations_count' => $accountOperationsCount,
            'achievements_count' => $achievementsCount,
            'completed_routines_count' => $completedRoutinesCount,
            'contacts_count' => $contactsCount,
            'goals_count' => $goalsCount,
            'notes_count' => $notesCount,
            'kpis_count' => $kpisCount,
            'profiles_count' => $profilesCount,
            'projects_count' => $projectsCount,
            'promotions_count' => $promotionsCount,
            'quotes_count' => $quotesCount,
            'reminder_messages_count' => $reminderMessagesCount,
            'reminders_count' => $remindersCount,
            'rewards_count' => $rewardsCount,
            'routines_count' => $routinesCount,
            'saved_emails_count' => $savedEmailsCount,
            'sent_reminders_count' => $sentRemindersCount,
            'user_kpis_count' => $userKpisCount,
            'users_count' => $usersCount,
        ]);
    }
}
