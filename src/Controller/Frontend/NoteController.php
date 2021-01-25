<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Achievement;
use App\Entity\Note;
use App\Entity\Routine;
use App\Entity\User;
use App\Factory\NoteFactory;
use App\Form\Frontend\NoteType;
use App\Manager\NoteManager;
use App\Repository\NoteRepository;
use App\Resource\KytResource;
use App\Security\Voter\NoteVoter;
use App\Security\Voter\RoutineVoter;
use App\Service\AchievementService;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $notesQuery = $noteRepository->findByParametersForFrontend($this->getUser(), $parameters);
        $notes = $paginator->paginate(
            $notesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('frontend/note/index.html.twig', [
            'know_your_tools' => $knowYourTools,
            'notes' => $notes,
            'parameters' => $parameters,
        ]);
    }

    /**
     * @Route("/new/{uuid?}", name="new", methods={"GET","POST"})
     */
    public function new(
        AchievementService $achievementService,
        NoteFactory $noteFactory,
        NoteManager $noteManager,
        Request $request,
        TranslatorInterface $translator,
        Routine $routine = null
    ): Response {
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $user = $this->getUser();
        $note = $noteFactory->createNote();
        if (null !== $routine) {
            $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);
            $note->setRoutine($routine);
        }
        $note->setUser($user);
        $user->addNote($note);
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $noteManager->save($note, (string) $user);
            $achievement = $achievementService->manageAchievements($user, Achievement::TYPE_CREATED_NOTE);

            if (null !== $achievement) {
                $this->addFlash(
                    'success',
                    $translator->trans('Congratulations! You have a new achievement!')
                );
            }

            if ($knowYourTools) {
                return $this->redirectToRoute('frontend_note_show', [
                    'know_your_tools' => KytResource::NOTES_SHOW,
                    'uuid' => $note->getUuid(),
                ]);
            } else {
                return $this->redirectToRoute('frontend_note_show', [
                    'uuid' => $note->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/note/new.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Note $note, Request $request): Response
    {
        $this->denyAccessUnlessGranted(NoteVoter::VIEW, $note);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        return $this->render('frontend/note/show.html.twig', [
            'know_your_tools' => $knowYourTools,
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
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $noteManager->save($note, (string) $this->getUser());

            if ($knowYourTools) {
                return $this->redirectToRoute('frontend_note_show', [
                    'know_your_tools' => KytResource::NOTES_FINISH,
                    'uuid' => $note->getUuid(),
                ]);
            } else {
                return $this->redirectToRoute('frontend_note_show', [
                    'uuid' => $note->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/note/edit.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
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
            sprintf(
                'delete%s',
                (string) $note->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $noteManager->softDelete($note, (string) $this->getUser());
        }

        return $this->redirectToRoute('frontend_note_index');
    }
}
