<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{Goal, User};
use App\Enum\UserRoleEnum;
use App\Manager\GoalManager;
use App\Repository\GoalRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_ADMIN->value)]
#[Route('/admin/goal', name: 'admin_goal_')]
class GoalController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        GoalRepository $goalRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $goalsQuery = $goalRepository->findByParametersForAdmin($parameters);
        $goals = $paginator->paginate(
            $goalsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $goals->getTotalItemCount();

        return $this->render('admin/goal/index.html.twig', [
            'goals' => $goals,
            'parameters' => $parameters,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Goal $goal): Response
    {
        return $this->render('admin/goal/show.html.twig', [
            'goal' => $goal,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Goal $goal,
        GoalManager $goalManager
    ): Response {
        $goalManager->undelete($goal);

        return $this->redirectToRoute(
            'admin_goal_show',
            [
                'uuid' => $goal->getUuid(),
            ],
            Response::HTTP_SEE_OTHER
        );
    }
}
