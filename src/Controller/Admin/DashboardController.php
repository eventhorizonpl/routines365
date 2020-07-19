<?php

namespace App\Controller\Admin;

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
        QuoteRepository $quoteRepository,
        UserRepository $userRepository
    ): Response {
        $quotesCount = $quoteRepository->count([]);
        $usersCount = $userRepository->count([]);

        return $this->render('admin/dashboard/index.html.twig', [
            'quotes_count' => $quotesCount,
            'users_count' => $usersCount,
        ]);
    }
}
