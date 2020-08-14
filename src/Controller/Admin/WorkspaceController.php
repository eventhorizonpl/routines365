<?php

namespace App\Controller\Admin;

use App\Repository\AccountRepository;
use App\Repository\AccountOperationRepository;
use App\Repository\GoalRepository;
use App\Repository\NoteRepository;
use App\Repository\ProfileRepository;
use App\Repository\QuoteRepository;
use App\Repository\ReminderMessageRepository;
use App\Repository\ReminderRepository;
use App\Repository\RoutineRepository;
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
        GoalRepository $goalRepository,
        NoteRepository $noteRepository,
        ProfileRepository $profileRepository,
        QuoteRepository $quoteRepository,
        ReminderMessageRepository $reminderMessageRepository,
        ReminderRepository $reminderRepository,
        RoutineRepository $routineRepository,
        UserRepository $userRepository
    ): Response {
        $accountsCount = $accountRepository->count([]);
        $accountOperationsCount = $accountOperationRepository->count([]);
        $goalsCount = $goalRepository->count([]);
        $notesCount = $noteRepository->count([]);
        $profilesCount = $profileRepository->count([]);
        $quotesCount = $quoteRepository->count([]);
        $reminderMessagesCount = $reminderMessageRepository->count([]);
        $remindersCount = $reminderRepository->count([]);
        $routinesCount = $routineRepository->count([]);
        $usersCount = $userRepository->count([]);

        return $this->render('admin/workspace/index.html.twig', [
            'accounts_count' => $accountsCount,
            'account_operations_count' => $accountOperationsCount,
            'goals_count' => $goalsCount,
            'notes_count' => $notesCount,
            'profiles_count' => $profilesCount,
            'quotes_count' => $quotesCount,
            'reminder_messages_count' => $reminderMessagesCount,
            'reminders_count' => $remindersCount,
            'routines_count' => $routinesCount,
            'users_count' => $usersCount,
        ]);
    }
}
