<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Repository\TestimonialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'frontend_home')]
    public function index(TestimonialRepository $testimonialRepository): Response
    {
        $testimonial = $testimonialRepository->findOneRand();

        return $this->render('frontend/home/index.html.twig', [
            'testimonial' => $testimonial,
        ]);
    }
}
