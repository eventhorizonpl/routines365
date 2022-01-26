<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Enum\UserRoleEnum;
use App\Factory\ContactFactory;
use App\Form\Frontend\ContactType;
use App\Manager\ContactManager;
use App\Service\EmailService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_USER->value)]
#[Route('/contact', name: 'frontend_contact_')]
class ContactController extends AbstractController
{
    #[Route('/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        ContactFactory $contactFactory,
        ContactManager $contactManager,
        EmailService $emailService,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        $user = $this->getUser();
        $contact = $contactFactory->createContact();
        $contact->setUser($user);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $contactManager->save($contact, (string) $user);

            $emailService->sendContactRequest(
                'contact@routines365.com',
                sprintf(
                    'Contact request from %s %s',
                    $contact->getUser()->getEmail(),
                    $contact->getTitle()
                ),
                [
                    'from_email' => $contact->getUser()->getEmail(),
                    'content' => $contact->getContent(),
                    'title' => $contact->getTitle(),
                    'type' => $contact->getType(),
                ]
            );

            $this->addFlash(
                'success',
                $translator->trans('We saved your contact request. We will get back to you soon.')
            );

            return $this->redirectToRoute('frontend_contact_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('frontend/contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }
}
