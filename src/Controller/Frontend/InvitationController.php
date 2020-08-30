<?php

namespace App\Controller\Frontend;

use App\Config;
use App\Entity\User;
use App\Form\Frontend\InvitationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
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
        MailerInterface $mailer,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        if (true !== Config::INVITATIONS_ENABLED) {
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

        $subject = $translator->trans('%firstName% %lastName% wants to invite you to Routines365.com', [
            '%firstName%' => $firstName,
            '%lastName%' => $lastName,
        ]);

        $form = $this->createForm(InvitationType::class);
        $form->handleRequest($request);
        $data = $form->getData();

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $email = (new TemplatedEmail())
                ->from(new Address('noreply@routines365.com', 'Routines365'))
                ->to($data['email'])
                ->subject($subject)
                ->htmlTemplate('email/invitation_email_content.html.twig')
                ->context([
                    'referrer_code' => $user->getReferrerCode(),
                ])
            ;

            $mailer->send($email);

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
