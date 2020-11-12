<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Note;
use App\Entity\User;
use App\Manager\NoteManager;
use App\Repository\NoteRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/note", name="admin_note_")
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

        $notesQuery = $noteRepository->findByParametersForAdmin($parameters);
        $notes = $paginator->paginate(
            $notesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/note/index.html.twig', [
            'notes' => $notes,
            'parameters' => $parameters,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        return $this->render('admin/note/show.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
    public function undelete(
        Note $note,
        NoteManager $noteManager
    ): Response {
        $noteManager->undelete($note);

        return $this->redirectToRoute('admin_note_show', [
            'uuid' => $note->getUuid(),
        ]);
    }
}
