<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\Frontend\PromotionCodeType;
use App\Resource\ConfigResource;
use App\Service\PromotionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @IsGranted(User::ROLE_USER)
 */
#[Route('/promotions', name: 'frontend_promotion_')]
class PromotionController extends AbstractController
{
    #[Route('/', methods: ['GET', 'POST'], name: 'code')]
    public function code(
        PromotionService $promotionService,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        if (true !== ConfigResource::PROMOTIONS_ENABLED) {
            return $this->redirectToRoute('frontend_home');
        }

        $user = $this->getUser();
        $promotions = $user->getPromotions();

        $form = $this->createForm(PromotionCodeType::class);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $promotionCodeFormModel = $form->getData();
            $used = $promotionService->applyExistingAccountPromotion(
                $promotionCodeFormModel->code,
                $user
            );

            if (true === $used) {
                $this->addFlash(
                    'success',
                    $translator->trans('You used promotion code.')
                );
            } else {
                $this->addFlash(
                    'danger',
                    $translator->trans('You cannot use this promotion code.')
                );
            }

            return $this->redirectToRoute('frontend_promotion_code');
        }

        return $this->render('frontend/promotion/code.html.twig', [
            'form' => $form->createView(),
            'promotions' => $promotions,
        ]);
    }
}
