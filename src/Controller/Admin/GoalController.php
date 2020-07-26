<?php

namespace App\Controller\Admin;

use App\Entity\Goal;
use App\Entity\User;
use App\Repository\GoalRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/goal", name="admin_goal_")
 */
class GoalController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        GoalRepository $goalRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'query' => trim($request->query->get('q')),
        ];

        $queryResult = $goalRepository->findByParametersForAdmin($parameters);
        $goals = $paginator->paginate(
            $queryResult,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/goal/index.html.twig', [
            'goals' => $goals,
            'parameters' => $parameters,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Goal $goal): Response
    {
        return $this->render('admin/goal/show.html.twig', [
            'goal' => $goal,
        ]);
    }
}
