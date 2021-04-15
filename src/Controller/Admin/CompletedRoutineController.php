<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{CompletedRoutine, User};
use App\Manager\CompletedRoutineManager;
use App\Repository\CompletedRoutineRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_ADMIN)]
#[Route('/admin/completed-routine', name: 'admin_completed_routine_')]
class CompletedRoutineController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        CompletedRoutineRepository $completedRoutineRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $completedRoutinesQuery = $completedRoutineRepository->findByParametersForAdmin($parameters);
        $completedRoutines = $paginator->paginate(
            $completedRoutinesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $completedRoutines->getTotalItemCount();

        return $this->render('admin/completed_routine/index.html.twig', [
            'completed_routines' => $completedRoutines,
            'parameters' => $parameters,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(CompletedRoutine $completedRoutine): Response
    {
        return $this->render('admin/completed_routine/show.html.twig', [
            'completed_routine' => $completedRoutine,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        CompletedRoutine $completedRoutine,
        CompletedRoutineManager $completedRoutineManager
    ): Response {
        $completedRoutineManager->undelete($completedRoutine);

        return $this->redirectToRoute('admin_completed_routine_show', [
            'uuid' => $completedRoutine->getUuid(),
        ]);
    }
}
