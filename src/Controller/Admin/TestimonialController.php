<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Testimonial;
use App\Entity\User;
use App\Form\Admin\TestimonialType;
use App\Manager\TestimonialManager;
use App\Repository\TestimonialRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/testimonial", name="admin_testimonial_")
 */
class TestimonialController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        TestimonialRepository $testimonialRepository
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'status' => trim((string) $request->query->get('status')),
        ];

        $testimonialsQuery = $testimonialRepository->findByParametersForAdmin($parameters);
        $testimonials = $paginator->paginate(
            $testimonialsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $testimonials->getTotalItemCount();

        return $this->render('admin/testimonial/index.html.twig', [
            'parameters' => $parameters,
            'testimonials' => $testimonials,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Testimonial $testimonial): Response
    {
        return $this->render('admin/testimonial/show.html.twig', [
            'testimonial' => $testimonial,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Testimonial $testimonial,
        TestimonialManager $testimonialManager
    ): Response {
        $form = $this->createForm(TestimonialType::class, $testimonial);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $testimonialManager->save($testimonial, (string) $this->getUser());

            return $this->redirectToRoute('admin_testimonial_show', [
                'uuid' => $testimonial->getUuid(),
            ]);
        }

        return $this->render('admin/testimonial/edit.html.twig', [
            'form' => $form->createView(),
            'testimonial' => $testimonial,
        ]);
    }

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
    public function undelete(
        Testimonial $testimonial,
        TestimonialManager $testimonialManager
    ): Response {
        $testimonialManager->undelete($testimonial);

        return $this->redirectToRoute('admin_testimonial_show', [
            'uuid' => $testimonial->getUuid(),
        ]);
    }
}
