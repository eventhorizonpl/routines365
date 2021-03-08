<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Promotion;
use App\Entity\SavedEmail;
use App\Entity\User;
use App\Form\Frontend\InvitationType;
use App\Resource\ConfigResource;
use App\Service\EmailService;
use App\Service\PromotionService;
use App\Service\SavedEmailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @IsGranted(User::ROLE_USER)
 */
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
            return $this->redirectToRoute('frontend_home');
        }

        $user = $this->getUser();
        $profile = $user->getProfile();
        $firstName = $profile->getFirstName();
        $lastName = $profile->getLastName();
        $promotion = $promotionService->getEnabledAndValidPromotion(
            'PLUS10NR',
            Promotion::TYPE_NEW_ACCOUNT
        );

        if ((null === $firstName) || ('' === trim($firstName)) || (null === $lastName) || ('' === trim($lastName))) {
            $this->addFlash(
                'danger',
                $translator->trans('Please provide your first and last name!')
            );

            return $this->redirectToRoute('frontend_profile_edit');
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
                SavedEmail::TYPE_INVITATION,
                $user
            );

            $this->addFlash(
                'success',
                $translator->trans('Email was sent. You can invite another person.')
            );

            return $this->redirectToRoute('frontend_invitation_send');
        }

        return $this->render('frontend/invitation/send.html.twig', [
            'first_name' => $firstName,
            'form' => $form->createView(),
            'last_name' => $lastName,
            'promotion' => $promotion,
            'referrer_code' => $user->getReferrerCode(),
            'subject' => $subject,
        ]);
    }
}
