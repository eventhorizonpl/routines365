<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/page', name: 'frontend_static_page_')]
class StaticPageController extends AbstractController
{
    #[Route('/about', methods: ['GET'], name: 'about')]
    public function about(): Response
    {
        return $this->redirectToRoute('frontend_home');
    }

    #[Route('/changelog', methods: ['GET'], name: 'changelog')]
    public function changelog(): Response
    {
        return $this->render('frontend/static_page/changelog.html.twig');
    }

    #[Route('/contact', methods: ['GET'], name: 'contact')]
    public function contact(): Response
    {
        return $this->render('frontend/static_page/contact.html.twig');
    }

    #[Route('/faq', methods: ['GET'], name: 'faq')]
    public function faq(): Response
    {
        return $this->render('frontend/static_page/faq.html.twig');
    }

    #[Route('/how-to', methods: ['GET'], name: 'how_to')]
    public function howTo(): Response
    {
        return $this->render('frontend/static_page/how_to/index.html.twig');
    }

    #[Route('/how-to/basic-configuration', methods: ['GET'], name: 'how_to_basic_configuration')]
    public function howToBasicConfiguration(): Response
    {
        return $this->render('frontend/static_page/how_to/basic_configuration.html.twig');
    }

    #[Route('/how-to/completing-routines', methods: ['GET'], name: 'how_to_completing_routines')]
    public function howToCompletingRoutines(): Response
    {
        return $this->render('frontend/static_page/how_to/completing_routines.html.twig');
    }

    #[Route('/how-to/goals', methods: ['GET'], name: 'how_to_goals')]
    public function howToGoals(): Response
    {
        return $this->render('frontend/static_page/how_to/goals.html.twig');
    }

    #[Route('/how-to/notes', methods: ['GET'], name: 'how_to_notes')]
    public function howToNotes(): Response
    {
        return $this->render('frontend/static_page/how_to/notes.html.twig');
    }

    #[Route('/how-to/projects', methods: ['GET'], name: 'how_to_projects')]
    public function howToProjects(): Response
    {
        return $this->render('frontend/static_page/how_to/projects.html.twig');
    }

    #[Route('/how-to/reminders', methods: ['GET'], name: 'how_to_reminders')]
    public function howToReminders(): Response
    {
        return $this->render('frontend/static_page/how_to/reminders.html.twig');
    }

    #[Route('/how-to/rewards', methods: ['GET'], name: 'how_to_rewards')]
    public function howToRewards(): Response
    {
        return $this->render('frontend/static_page/how_to/rewards.html.twig');
    }

    #[Route('/how-to/routines', methods: ['GET'], name: 'how_to_routines')]
    public function howToRoutines(): Response
    {
        return $this->render('frontend/static_page/how_to/routines.html.twig');
    }

    #[Route('/privacy-policy', methods: ['GET'], name: 'privacy_policy')]
    public function privacyPolicy(): Response
    {
        return $this->render('frontend/static_page/privacy_policy.html.twig');
    }

    #[Route('/terms-and-conditions', methods: ['GET'], name: 'terms_and_conditions')]
    public function termsAndConditions(): Response
    {
        return $this->render('frontend/static_page/terms_and_conditions.html.twig');
    }

    #[Route('/theme', methods: ['GET'], name: 'theme')]
    public function theme(): Response
    {
        return $this->render('frontend/static_page/theme.html.twig');
    }
}
