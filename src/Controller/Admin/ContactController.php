<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\Admin\ContactType;
use App\Manager\ContactManager;
use App\Repository\ContactRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_ADMIN)]
#[Route('/admin/contact', name: 'admin_contact_')]
class ContactController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        ContactRepository $contactRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'status' => trim((string) $request->query->get('status')),
            'type' => trim((string) $request->query->get('type')),
        ];

        $contactsQuery = $contactRepository->findByParametersForAdmin($parameters);
        $contacts = $paginator->paginate(
            $contactsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $contacts->getTotalItemCount();

        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contacts,
            'parameters' => $parameters,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Contact $contact): Response
    {
        return $this->render('admin/contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{uuid}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        Contact $contact,
        ContactManager $contactManager,
        Request $request
    ): Response {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $contactManager->save($contact, (string) $this->getUser());

            return $this->redirectToRoute('admin_contact_show', [
                'uuid' => $contact->getUuid(),
            ]);
        }

        return $this->render('admin/contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Contact $contact,
        ContactManager $contactManager
    ): Response {
        $contactManager->undelete($contact);

        return $this->redirectToRoute('admin_contact_show', [
            'uuid' => $contact->getUuid(),
        ]);
    }
}
