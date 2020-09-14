<?php

namespace App\Controller\Admin;

use App\Repository\AccountOperationRepository;
use App\Repository\AccountRepository;
use App\Repository\CompletedRoutineRepository;
use App\Repository\GoalRepository;
use App\Repository\KpiRepository;
use App\Repository\NoteRepository;
use App\Repository\ProfileRepository;
use App\Repository\QuoteRepository;
use App\Repository\ReminderMessageRepository;
use App\Repository\ReminderRepository;
use App\Repository\RoutineRepository;
use App\Repository\SentReminderRepository;
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
        CompletedRoutineRepository $completedRoutineRepository,
        GoalRepository $goalRepository,
        NoteRepository $noteRepository,
        KpiRepository $kpiRepository,
        ProfileRepository $profileRepository,
        QuoteRepository $quoteRepository,
        ReminderMessageRepository $reminderMessageRepository,
        ReminderRepository $reminderRepository,
        RoutineRepository $routineRepository,
        SentReminderRepository $sentReminderRepository,
        UserRepository $userRepository
    ): Response {
        $accountsCount = $accountRepository->count([]);
        $accountOperationsCount = $accountOperationRepository->count([]);
        $completedRoutinesCount = $completedRoutineRepository->count([]);
        $goalsCount = $goalRepository->count([]);
        $notesCount = $noteRepository->count([]);
        $kpisCount = $kpiRepository->count([]);
        $profilesCount = $profileRepository->count([]);
        $quotesCount = $quoteRepository->count([]);
        $reminderMessagesCount = $reminderMessageRepository->count([]);
        $remindersCount = $reminderRepository->count([]);
        $routinesCount = $routineRepository->count([]);
        $sentRemindersCount = $sentReminderRepository->count([]);
        $usersCount = $userRepository->count([]);

        return $this->render('admin/workspace/index.html.twig', [
            'accounts_count' => $accountsCount,
            'account_operations_count' => $accountOperationsCount,
            'completed_routines_count' => $completedRoutinesCount,
            'goals_count' => $goalsCount,
            'notes_count' => $notesCount,
            'kpis_count' => $kpisCount,
            'profiles_count' => $profilesCount,
            'quotes_count' => $quotesCount,
            'reminder_messages_count' => $reminderMessagesCount,
            'reminders_count' => $remindersCount,
            'routines_count' => $routinesCount,
            'sent_reminders_count' => $sentRemindersCount,
            'users_count' => $usersCount,
        ]);
    }
}
