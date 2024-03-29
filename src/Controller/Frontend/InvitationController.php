<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\{Promotion, SavedEmail, User};
use App\Enum\{PromotionTypeEnum, SavedEmailTypeEnum, UserRoleEnum};
use App\Form\Frontend\InvitationType;
use App\Resource\ConfigResource;
use App\Service\{EmailService, PromotionService, SavedEmailService};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_USER)]
#[Route('/invitations', name: 'frontend_invitation_')]
class InvitationController extends AbstractController
{
    #[Route('/send', methods: ['GET', 'POST'], name: 'send')]
    public function send(
        EmailService $emailService,
        PromotionService $promotionService,
        Request $request,
        SavedEmailService $savedEmailService,
        TranslatorInterface $translator
    ): Response {
        if (true !== ConfigResource::INVITATIONS_ENABLED) {
            return $this->redirectToRoute('frontend_home', [], Response::HTTP_SEE_OTHER);
        }

        $user = $this->getUser();
        $profile = $user->getProfile();
        $firstName = $profile->getFirstName();
        $lastName = $profile->getLastName();
        $promotion = $promotionService->getEnabledAndValidPromotion(
            'PLUS10NR',
            PromotionTypeEnum::NEW_ACCOUNT
        );

        if ((null === $firstName) || ('' === trim($firstName)) || (null === $lastName) || ('' === trim($lastName))) {
            $this->addFlash(
                'danger',
                $translator->trans('Please provide your first and last name!')
            );

            return $this->redirectToRoute('frontend_profile_edit', [], Response::HTTP_SEE_OTHER);
        }

        $subject = sprintf(
            '%s %s %s',
            $firstName,
            $lastName,
            $translator->trans('invites you to Routines365.com')
        );

        $form = $this->createForm(InvitationType::class);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $invitationEmailFormModel = $form->getData();
            $emailService->sendInvitation(
                $invitationEmailFormModel->email,
                $subject,
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'promotion' => $promotion,
                    'referrer_code' => $user->getReferrerCode(),
                ]
            );

            $savedEmailService->create(
                $invitationEmailFormModel->email,
                SavedEmailTypeEnum::INVITATION,
                $user
            );

            $this->addFlash(
                'success',
                $translator->trans('Email was sent. You can invite another person.')
            );

            return $this->redirectToRoute('frontend_invitation_send', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frontend/invitation/send.html.twig', [
            'first_name' => $firstName,
            'form' => $form,
            'last_name' => $lastName,
            'promotion' => $promotion,
            'referrer_code' => $user->getReferrerCode(),
            'subject' => $subject,
        ]);
    }
}
