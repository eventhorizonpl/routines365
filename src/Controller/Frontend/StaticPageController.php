<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/page", name="frontend_static_page_")
 */
class StaticPageController extends AbstractController
{
    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->redirectToRoute('frontend_home');
    }

    /**
     * @Route("/changelog", name="changelog")
     */
    public function changelog(): Response
    {
        return $this->render('frontend/static_page/changelog.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('frontend/static_page/contact.html.twig');
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(): Response
    {
        return $this->render('frontend/static_page/faq.html.twig');
    }

    /**
     * @Route("/how-to", name="how_to")
     */
    public function howTo(): Response
    {
        return $this->render('frontend/static_page/how_to/index.html.twig');
    }

    /**
     * @Route("/how-to/basic-configuration", name="how_to_basic_configuration")
     */
    public function howToBasicConfiguration(): Response
    {
        return $this->render('frontend/static_page/how_to/basic_configuration.html.twig');
    }

    /**
     * @Route("/how-to/completing-routines", name="how_to_completing_routines")
     */
    public function howToCompletingRoutines(): Response
    {
        return $this->render('frontend/static_page/how_to/completing_routines.html.twig');
    }

    /**
     * @Route("/how-to/goals", name="how_to_goals")
     */
    public function howToGoals(): Response
    {
        return $this->render('frontend/static_page/how_to/goals.html.twig');
    }

    /**
     * @Route("/how-to/notes", name="how_to_notes")
     */
    public function howToNotes(): Response
    {
        return $this->render('frontend/static_page/how_to/notes.html.twig');
    }

    /**
     * @Route("/how-to/projects", name="how_to_projects")
     */
    public function howToProjects(): Response
    {
        return $this->render('frontend/static_page/how_to/projects.html.twig');
    }

    /**
     * @Route("/how-to/reminders", name="how_to_reminders")
     */
    public function howToReminders(): Response
    {
        return $this->render('frontend/static_page/how_to/reminders.html.twig');
    }

    /**
     * @Route("/how-to/rewards", name="how_to_rewards")
     */
    public function howToRewards(): Response
    {
        return $this->render('frontend/static_page/how_to/rewards.html.twig');
    }

    /**
     * @Route("/how-to/routines", name="how_to_routines")
     */
    public function howToRoutines(): Response
    {
        return $this->render('frontend/static_page/how_to/routines.html.twig');
    }

    /**
     * @Route("/privacy-policy", name="privacy_policy")
     */
    public function privacyPolicy(): Response
    {
        return $this->render('frontend/static_page/privacy_policy.html.twig');
    }

    /**
     * @Route("/terms-and-conditions", name="terms_and_conditions")
     */
    public function termsAndConditions(): Response
    {
        return $this->render('frontend/static_page/terms_and_conditions.html.twig');
    }

    /**
     * @Route("/theme", name="theme")
     */
    public function theme(): Response
    {
        return $this->render('frontend/static_page/theme.html.twig');
    }
}
