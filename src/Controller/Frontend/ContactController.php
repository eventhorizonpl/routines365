<?php

namespace App\Controller\Frontend;

use App\Entity\Contact;
use App\Entity\User;
use App\Factory\ContactFactory;
use App\Form\Frontend\ContactType;
use App\Manager\ContactManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/contact", name="frontend_contact_")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(
        ContactFactory $contactFactory,
        ContactManager $contactManager,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        $contact = $contactFactory->createContact();
        $contact->setUser($this->getUser());
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $contactManager->save($contact, $this->getUser());

            $this->addFlash(
                'success',
                $translator->trans('We saved your contact request. We will get back to you soon.')
            );

            return $this->redirectToRoute('frontend_contact_new');
        }

        return $this->render('frontend/contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }
}
