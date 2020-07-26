<?php

namespace App\Controller\Admin;

use App\Repository\GoalRepository;
use App\Repository\ProfileRepository;
use App\Repository\QuoteRepository;
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
        ProfileRepository $profileRepository,
        QuoteRepository $quoteRepository,
        RoutineRepository $routineRepository,
        UserRepository $userRepository
    ): Response {
        $goalsCount = $goalRepository->count([]);
        $profilesCount = $profileRepository->count([]);
        $quotesCount = $quoteRepository->count([]);
        $routinesCount = $routineRepository->count([]);
        $usersCount = $userRepository->count([]);

        return $this->render('admin/dashboard/index.html.twig', [
            'goals_count' => $goalsCount,
            'profiles_count' => $profilesCount,
            'quotes_count' => $quotesCount,
            'routines_count' => $routinesCount,
            'users_count' => $usersCount,
        ]);
    }
}
