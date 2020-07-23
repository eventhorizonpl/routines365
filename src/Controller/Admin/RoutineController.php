<?php

namespace App\Controller\Admin;

use App\Entity\Routine;
use App\Entity\User;
use App\Repository\RoutineRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/routine", name="admin_routine_")
 */
class RoutineController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        RoutineRepository $routineRepository
    ): Response {
        $parameters = [
            'query' => $request->query->get('q'),
            'type' => $request->query->get('type'),
        ];

        $queryResult = $routineRepository->findByParametersForAdmin($parameters);
        $routines = $paginator->paginate(
            $queryResult,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/routine/index.html.twig', [
            'parameters' => $parameters,
            'routines' => $routines,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Routine $routine): Response
    {
        return $this->render('admin/routine/show.html.twig', [
            'routine' => $routine,
        ]);
    }
}
