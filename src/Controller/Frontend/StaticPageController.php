<?php

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
        return $this->render('frontend/static_page/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('frontend/static_page/contact.html.twig');
    }

    /**
     * @Route("/disclaimer", name="disclaimer")
     */
    public function disclaimer(): Response
    {
        return $this->render('frontend/static_page/disclaimer.html.twig');
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(): Response
    {
        return $this->render('frontend/static_page/faq.html.twig');
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
}
