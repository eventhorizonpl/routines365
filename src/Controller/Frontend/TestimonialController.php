<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\{Testimonial, User};
use App\Enum\{TestimonialStatusEnum, UserRoleEnum};
use App\Factory\TestimonialFactory;
use App\Form\Frontend\TestimonialType;
use App\Manager\TestimonialManager;
use App\Service\UserKytService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_USER)]
#[Route('/testimonial', name: 'frontend_testimonial_')]
class TestimonialController extends AbstractController
{
    #[Route('/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        TestimonialFactory $testimonialFactory,
        TestimonialManager $testimonialManager,
        Request $request,
        TranslatorInterface $translator,
        UserKytService $userKytService
    ): Response {
        $user = $this->getUser();
        if (null !== $user->getTestimonial()) {
            $testimonial = $user->getTestimonial();
        } else {
            $testimonial = $testimonialFactory->createTestimonial();
            $testimonial->setUser($user);
        }
        if (TestimonialStatusEnum::ACCEPTED === $testimonial->getStatus()) {
            $this->addFlash(
                'success',
                $translator->trans('We already accepted your testimonial.')
            );

            return $this->redirectToRoute('frontend_home', [], Response::HTTP_SEE_OTHER);
        }
        $form = $this->createForm(TestimonialType::class, $testimonial);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $testimonialManager->save($testimonial, (string) $user);

            $this->addFlash(
                'success',
                $translator->trans('We saved your testimonial.')
            );

            if (null === $user->getTestimonial()) {
                $userKyt = $user->getUserKyt();
                $used = $userKytService->rewardUserKyt($userKyt);

                if (true === $used) {
                    $this->addFlash(
                        'success',
                        $translator->trans('We added a small reward to your account.')
                    );
                }
            }

            return $this->redirectToRoute('frontend_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frontend/testimonial/new.html.twig', [
            'form' => $form,
            'testimonial' => $testimonial,
        ]);
    }
}
