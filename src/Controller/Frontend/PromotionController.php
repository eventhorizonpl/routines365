<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Enum\UserRoleEnum;
use App\Form\Frontend\PromotionCodeType;
use App\Resource\ConfigResource;
use App\Service\PromotionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_USER->value)]
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

            return $this->redirectToRoute('frontend_promotion_code', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frontend/promotion/code.html.twig', [
            'form' => $form,
            'promotions' => $promotions,
        ]);
    }
}
