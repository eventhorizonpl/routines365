<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Enum\UserRoleEnum;
use App\Repository\AchievementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_USER)]
#[Route('/achievements', name: 'frontend_achievement_')]
class AchievementController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        AchievementRepository $achievementRepository
    ): Response {
        $achievements = $achievementRepository->findForFrontend();

        return $this->render('frontend/achievement/index.html.twig', [
            'achievements' => $achievements,
            'user' => $this->getUser(),
        ]);
    }
}
