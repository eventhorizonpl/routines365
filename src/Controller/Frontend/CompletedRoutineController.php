<?php

namespace App\Controller\Frontend;

use App\Entity\Routine;
use App\Entity\User;
use App\Factory\CompletedRoutineFactory;
use App\Form\Frontend\CompletedRoutineType;
use App\Manager\CompletedRoutineManager;
use App\Security\Voter\RoutineVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/completed-routines", name="frontend_completed_routine_")
 */
class CompletedRoutineController extends AbstractController
{
    /**
     * @Route("/{uuid}/new", name="new", methods={"GET","POST"})
     */
    public function new(
        CompletedRoutineFactory $completedRoutineFactory,
        CompletedRoutineManager $completedRoutineManager,
        Request $request,
        Routine $routine
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);

        $completedRoutine = $completedRoutineFactory->createCompletedRoutine();
        $completedRoutine->setRoutine($routine);
        $completedRoutine->setUser($this->getUser());
        $form = $this->createForm(CompletedRoutineType::class, $completedRoutine);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $completedRoutineManager->save($completedRoutine, $this->getUser());

            return $this->redirectToRoute('frontend_routine_show', [
                'uuid' => $routine->getUuid(),
            ]);
        }

        return $this->render('frontend/completed_routine/new.html.twig', [
            'completed_routine' => $completedRoutine,
            'form' => $form->createView(),
            'routine' => $routine,
        ]);
    }
}
