<?php

namespace App\Controller\Admin;

use App\Repository\GoalRepository;
use App\Repository\NoteRepository;
use App\Repository\ProfileRepository;
use App\Repository\QuoteRepository;
use App\Repository\ReminderRepository;
use App\Repository\RoutineRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(
        GoalRepository $goalRepository,
        NoteRepository $noteRepository,
        ProfileRepository $profileRepository,
        QuoteRepository $quoteRepository,
        ReminderRepository $reminderRepository,
        RoutineRepository $routineRepository,
        UserRepository $userRepository
    ): Response {
        $goalsCount = $goalRepository->count([]);
        $notesCount = $noteRepository->count([]);
        $profilesCount = $profileRepository->count([]);
        $quotesCount = $quoteRepository->count([]);
        $remindersCount = $reminderRepository->count([]);
        $routinesCount = $routineRepository->count([]);
        $usersCount = $userRepository->count([]);

        return $this->render('admin/dashboard/index.html.twig', [
            'goals_count' => $goalsCount,
            'notes_count' => $notesCount,
            'profiles_count' => $profilesCount,
            'quotes_count' => $quotesCount,
            'reminders_count' => $remindersCount,
            'routines_count' => $routinesCount,
            'users_count' => $usersCount,
        ]);
    }
}
