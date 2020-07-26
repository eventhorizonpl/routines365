<?php

namespace App\Controller\Frontend;

use App\Entity\Goal;
use App\Entity\Routine;
use App\Entity\User;
use App\Factory\GoalFactory;
use App\Form\Frontend\GoalType;
use App\Manager\GoalManager;
use App\Repository\GoalRepository;
use App\Security\Voter\GoalVoter;
use App\Security\Voter\RoutineVoter;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/goals", name="frontend_goal_")
 */
class GoalController extends AbstractController
{
    /**
     * @Route("/{uuid}/new", name="new", methods={"GET","POST"})
     */
    public function new(
        GoalFactory $goalFactory,
        GoalManager $goalManager,
        Request $request,
        Routine $routine
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);

        $goal = $goalFactory->createGoal();
        $goal->setRoutine($routine);
        $goal->setUser($this->getUser());
        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $goalManager->save($goal, $this->getUser());

            return $this->redirectToRoute('frontend_routine_show', [
                'uuid' => $routine->getUuid(),
            ]);
        }

        return $this->render('frontend/goal/new.html.twig', [
            'form' => $form->createView(),
            'goal' => $goal,
            'routine' => $routine,
        ]);
    }

    /**
     * @Route("/{uuid}/complete", name="complete", methods={"GET"})
     */
    public function complete(
        Goal $goal,
        GoalManager $goalManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(GoalVoter::EDIT, $goal);

        $goal->setIsCompleted(true);
        $goalManager->save($goal, $this->getUser());

        return $this->redirectToRoute('frontend_routine_show', [
            'uuid' => $goal->getRoutine()->getUuid(),
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Goal $goal,
        GoalManager $goalManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(GoalVoter::EDIT, $goal);

        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $goalManager->save($goal, $this->getUser());

            return $this->redirectToRoute('frontend_routine_show', [
                'uuid' => $goal->getRoutine()->getUuid(),
            ]);
        }

        return $this->render('frontend/goal/edit.html.twig', [
            'form' => $form->createView(),
            'goal' => $goal,
            'routine' => $goal->getRoutine(),
        ]);
    }

    /**
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Goal $goal,
        GoalManager $goalManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(GoalVoter::DELETE, $goal);

        if (true === $this->isCsrfTokenValid(
            'delete'.$goal->getUuid(),
            $request->request->get('_token')
        )) {
            $goalManager->softDelete($goal, $this->getUser());
        }

        return $this->redirectToRoute('frontend_routine_show', [
            'uuid' => $goal->getRoutine()->getUuid(),
        ]);
    }
}
