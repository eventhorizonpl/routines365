<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Routine;
use App\Entity\User;
use App\Factory\RoutineFactory;
use App\Form\Frontend\RoutineType;
use App\Manager\RoutineManager;
use App\Repository\RoutineRepository;
use App\Resource\KytResource;
use App\Security\Voter\RoutineVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 */
#[Route('/routines', name: 'frontend_routine_')]
class RoutineController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        Request $request,
        RoutineRepository $routineRepository
    ): Response {
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));
        $parameters = [
            'query' => trim((string) $request->query->get('q')),
            'type' => $request->query->get('type'),
        ];

        $routines = $routineRepository->findByParametersForFrontend($this->getUser(), $parameters);

        return $this->render('frontend/routine/index.html.twig', [
            'know_your_tools' => $knowYourTools,
            'parameters' => $parameters,
            'routines' => $routines,
        ]);
    }

    #[Route('/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        Request $request,
        RoutineFactory $routineFactory,
        RoutineManager $routineManager
    ): Response {
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));
        $routine = $routineFactory->createRoutine();
        $routine->setUser($this->getUser());
        $form = $this->createForm(RoutineType::class, $routine);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $routineManager->save($routine, (string) $this->getUser());

            if ($knowYourTools) {
                return $this->redirectToRoute('frontend_routine_show', [
                    'know_your_tools' => KytResource::ROUTINES_SHOW,
                    'uuid' => $routine->getUuid(),
                ]);
            } else {
                return $this->redirectToRoute('frontend_routine_show', [
                    'uuid' => $routine->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/routine/new.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
            'routine' => $routine,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Request $request, Routine $routine): Response
    {
        $this->denyAccessUnlessGranted(RoutineVoter::VIEW, $routine);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        return $this->render('frontend/routine/show_completed_routines.html.twig', [
            'know_your_tools' => $knowYourTools,
            'routine' => $routine,
        ]);
    }

    #[Route('/{uuid}/goals', methods: ['GET'], name: 'show_goals')]
    public function showGoals(Request $request, Routine $routine): Response
    {
        $this->denyAccessUnlessGranted(RoutineVoter::VIEW, $routine);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        return $this->render('frontend/routine/show_goals.html.twig', [
            'know_your_tools' => $knowYourTools,
            'routine' => $routine,
        ]);
    }

    #[Route('/{uuid}/notes', methods: ['GET'], name: 'show_notes')]
    public function showNotes(Routine $routine): Response
    {
        $this->denyAccessUnlessGranted(RoutineVoter::VIEW, $routine);

        return $this->render('frontend/routine/show_notes.html.twig', [
            'routine' => $routine,
        ]);
    }

    #[Route('/{uuid}/reminders', methods: ['GET'], name: 'show_reminders')]
    public function showReminders(Request $request, Routine $routine): Response
    {
        $this->denyAccessUnlessGranted(RoutineVoter::VIEW, $routine);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        return $this->render('frontend/routine/show_reminders.html.twig', [
            'know_your_tools' => $knowYourTools,
            'routine' => $routine,
        ]);
    }

    #[Route('/{uuid}/rewards', methods: ['GET'], name: 'show_rewards')]
    public function showRewards(Routine $routine): Response
    {
        $this->denyAccessUnlessGranted(RoutineVoter::VIEW, $routine);

        return $this->render('frontend/routine/show_rewards.html.twig', [
            'routine' => $routine,
        ]);
    }

    #[Route('/{uuid}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        Request $request,
        Routine $routine,
        RoutineManager $routineManager
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $form = $this->createForm(RoutineType::class, $routine);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $routineManager->save($routine, (string) $this->getUser());

            if ($knowYourTools) {
                return $this->redirectToRoute('frontend_routine_show', [
                    'know_your_tools' => KytResource::ROUTINES_FINISH,
                    'uuid' => $routine->getUuid(),
                ]);
            } else {
                return $this->redirectToRoute('frontend_routine_show', [
                    'uuid' => $routine->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/routine/edit.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
            'routine' => $routine,
        ]);
    }

    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        Request $request,
        Routine $routine,
        RoutineManager $routineManager
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::DELETE, $routine);

        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $routine->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $routineManager->softDelete($routine, (string) $this->getUser());
        }

        return $this->redirectToRoute('frontend_routine_index');
    }
}
