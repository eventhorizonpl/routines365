<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\{Achievement, Note, Routine, User};
use App\Enum\{AchievementTypeEnum, UserRoleEnum};
use App\Factory\NoteFactory;
use App\Form\Frontend\NoteType;
use App\Manager\NoteManager;
use App\Repository\NoteRepository;
use App\Resource\KytResource;
use App\Security\Voter\{NoteVoter, RoutineVoter};
use App\Service\AchievementService;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_USER)]
#[Route('/notes', name: 'frontend_note_')]
class NoteController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
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

    #[Route('/new/{context}/{uuid?}', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        AchievementService $achievementService,
        string $context,
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
            $achievement = $achievementService->manageAchievements($user, AchievementTypeEnum::CREATED_NOTE);

            if (null !== $achievement) {
                $this->addFlash(
                    'success',
                    $translator->trans('Congratulations! You have a new achievement!')
                );
            }

            if (Note::CONTEXT_DEFAULT === $context) {
                if ($knowYourTools) {
                    return $this->redirectToRoute(
                        'frontend_note_show',
                        [
                            'know_your_tools' => KytResource::NOTES_SHOW,
                            'uuid' => $note->getUuid(),
                        ],
                        Response::HTTP_SEE_OTHER
                    );
                }

                return $this->redirectToRoute(
                    'frontend_note_show',
                    [
                        'uuid' => $note->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }
            if (Note::CONTEXT_ROUTINE === $context) {
                return $this->redirectToRoute(
                    'frontend_routine_show_notes',
                    [
                        'uuid' => $note->getRoutine()->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }
        }

        return $this->render('frontend/note/new.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
            'note' => $note,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Note $note, Request $request): Response
    {
        $this->denyAccessUnlessGranted(NoteVoter::VIEW, $note);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        return $this->render('frontend/note/show.html.twig', [
            'know_your_tools' => $knowYourTools,
            'note' => $note,
        ]);
    }

    #[Route('/{uuid}/{context}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        string $context,
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

            if (Note::CONTEXT_DEFAULT === $context) {
                if ($knowYourTools) {
                    return $this->redirectToRoute(
                        'frontend_note_show',
                        [
                            'know_your_tools' => KytResource::NOTES_FINISH,
                            'uuid' => $note->getUuid(),
                        ],
                        Response::HTTP_SEE_OTHER
                    );
                }

                return $this->redirectToRoute(
                    'frontend_note_show',
                    [
                        'uuid' => $note->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }
            if (Note::CONTEXT_ROUTINE === $context) {
                return $this->redirectToRoute(
                    'frontend_routine_show_notes',
                    [
                        'uuid' => $note->getRoutine()->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }
        }

        return $this->render('frontend/note/edit.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
            'note' => $note,
        ]);
    }

    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
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

        return $this->redirectToRoute('frontend_note_index', [], Response::HTTP_SEE_OTHER);
    }
}
