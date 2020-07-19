<?php

namespace App\Controller\Admin;

use App\Repository\ProfileRepository;
use App\Repository\QuoteRepository;
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
        ProfileRepository $profileRepository,
        QuoteRepository $quoteRepository,
        UserRepository $userRepository
    ): Response {
        $profilesCount = $profileRepository->count([]);
        $quotesCount = $quoteRepository->count([]);
        $usersCount = $userRepository->count([]);

        return $this->render('admin/dashboard/index.html.twig', [
            'profiles_count' => $profilesCount,
            'quotes_count' => $quotesCount,
            'users_count' => $usersCount,
        ]);
    }
}
