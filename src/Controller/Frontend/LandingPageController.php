<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Promotion;
use App\Service\PromotionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/landing-page", name="frontend_landing_page_")
 */
class LandingPageController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('frontend/landing_page/index.html.twig');
    }

    /**
     * @Route("/improve-memory", name="improve_memory")
     */
    public function improveMemory(): Response
    {
        return $this->render('frontend/landing_page/improve_memory.html.twig');
    }

    /**
     * @Route("/learn-faster", name="learn_faster")
     */
    public function learnFaster(): Response
    {
        return $this->render('frontend/landing_page/learn_faster.html.twig');
    }

    public function register(PromotionService $promotionService): Response
    {
        $promotion = $promotionService->getEnabledAndValidPromotion(
            'PLUS10NR',
            Promotion::TYPE_NEW_ACCOUNT
        );

        return $this->render('frontend/landing_page/_register.html.twig', [
            'promotion' => $promotion,
        ]);
    }
}
