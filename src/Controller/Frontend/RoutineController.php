<?php

namespace App\Controller\Frontend;

use App\Entity\Routine;
use App\Entity\User;
use App\Factory\RoutineFactory;
use App\Form\Frontend\RoutineType;
use App\Manager\RoutineManager;
use App\Repository\RoutineRepository;
use App\Security\Voter\RoutineVoter;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/routines", name="frontend_routine_")
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

        $routines = $routineRepository->findByParametersForFrontend($this->getUser(), $parameters);

        return $this->render('frontend/routine/index.html.twig', [
            'parameters' => $parameters,
            'routines' => $routines,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        RoutineFactory $routineFactory,
        RoutineManager $routineManager
    ): Response {
        $routine = $routineFactory->createRoutine();
        $routine->setUser($this->getUser());
        $form = $this->createForm(RoutineType::class, $routine);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $routineManager->save($routine, $this->getUser());

            return $this->redirectToRoute('frontend_routine_show', [
                'uuid' => $routine->getUuid(),
            ]);
        }

        return $this->render('frontend/routine/new.html.twig', [
            'form' => $form->createView(),
            'routine' => $routine,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Routine $routine): Response
    {
        $this->denyAccessUnlessGranted(RoutineVoter::VIEW, $routine);

        return $this->render('frontend/routine/show.html.twig', [
            'routine' => $routine,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Request $request,
        Routine $routine,
        RoutineManager $routineManager
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);

        $form = $this->createForm(RoutineType::class, $routine);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $routineManager->save($routine, $this->getUser());

            return $this->redirectToRoute('frontend_routine_show', [
                'uuid' => $routine->getUuid(),
            ]);
        }

        return $this->render('frontend/routine/edit.html.twig', [
            'form' => $form->createView(),
            'routine' => $routine,
        ]);
    }

    /**
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Request $request,
        Routine $routine,
        RoutineManager $routineManager
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::DELETE, $routine);

        if (true === $this->isCsrfTokenValid(
            'delete'.$routine->getUuid(),
            $request->request->get('_token')
        )) {
            $routineManager->softDelete($routine, $this->getUser());
        }

        return $this->redirectToRoute('frontend_routine_index');
    }
}
