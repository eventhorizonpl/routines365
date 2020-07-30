<?php

namespace App\Controller\Frontend;

use App\Entity\Note;
use App\Entity\Routine;
use App\Entity\User;
use App\Factory\NoteFactory;
use App\Form\Frontend\NoteType;
use App\Manager\NoteManager;
use App\Repository\NoteRepository;
use App\Security\Voter\NoteVoter;
use App\Security\Voter\RoutineVoter;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/notes", name="frontend_note_")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        NoteRepository $noteRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim($request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $queryResult = $noteRepository->findByParametersForFrontend($this->getUser(), $parameters);
        $notes = $paginator->paginate(
            $queryResult,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('frontend/note/index.html.twig', [
            'notes' => $notes,
            'parameters' => $parameters,
        ]);
    }

    /**
     * @Route("/new/{uuid?}", name="new", methods={"GET","POST"})
     */
    public function new(
        NoteFactory $noteFactory,
        NoteManager $noteManager,
        Request $request,
        Routine $routine = null
    ): Response {
        $note = $noteFactory->createNote();
        if (null !== $routine) {
            $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);
            $note->setRoutine($routine);
        }
        $note->setUser($this->getUser());
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $noteManager->save($note, $this->getUser());

            return $this->redirectToRoute('frontend_note_show', [
                'uuid' => $note->getUuid(),
            ]);
        }

        return $this->render('frontend/note/new.html.twig', [
            'form' => $form->createView(),
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        $this->denyAccessUnlessGranted(NoteVoter::VIEW, $note);

        return $this->render('frontend/note/show.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Note $note,
        NoteManager $noteManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(NoteVoter::EDIT, $note);

        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $noteManager->save($note, $this->getUser());

            return $this->redirectToRoute('frontend_note_show', [
                'uuid' => $note->getUuid(),
            ]);
        }

        return $this->render('frontend/note/edit.html.twig', [
            'form' => $form->createView(),
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Note $note,
        NoteManager $noteManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(NoteVoter::DELETE, $note);

        if (true === $this->isCsrfTokenValid(
            'delete'.$note->getUuid(),
            $request->request->get('_token')
        )) {
            $noteManager->softDelete($note, $this->getUser());
        }

        return $this->redirectToRoute('frontend_note_index');
    }
}
