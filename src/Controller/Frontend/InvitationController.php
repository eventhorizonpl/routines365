<?php

namespace App\Controller\Frontend;

use App\Entity\SavedEmail;
use App\Entity\User;
use App\Form\Frontend\InvitationType;
use App\Resource\ConfigResource;
use App\Service\EmailService;
use App\Service\SavedEmailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/invitations", name="frontend_invitation_")
 */
class InvitationController extends AbstractController
{
    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(
        EmailService $emailService,
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

        if ((null === $firstName) or ('' === trim($firstName)) or (null === $lastName) or ('' === trim($lastName))) {
            $this->addFlash(
                'danger',
                $translator->trans('Please provide your first and last name!')
            );

            return $this->redirectToRoute('frontend_profile_edit');
        }

        $subject = $firstName.' '.$lastName.' '.$translator->trans('invites you to Routines365.com');

        $form = $this->createForm(InvitationType::class);
        $form->handleRequest($request);
        $data = $form->getData();

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $emailService->sendInvitation(
                $data['email'],
                $subject,
                [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'referrer_code' => $user->getReferrerCode(),
                ]
            );

            $savedEmailService->create(
                $data['email'],
                SavedEmail::TYPE_INVITATION,
                $user
            );

            $this->addFlash(
                'success',
                $translator->trans('Email was sent. You can invite another person.')
            );

            return $this->redirectToRoute('frontend_invitation_new');
        }

        return $this->render('frontend/invitation/new.html.twig', [
            'first_name' => $firstName,
            'form' => $form->createView(),
            'last_name' => $lastName,
            'referrer_code' => $user->getReferrerCode(),
            'subject' => $subject,
        ]);
    }
}
