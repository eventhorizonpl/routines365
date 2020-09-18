<?php

namespace App\Controller\Frontend;

use App\Entity\Reward;
use App\Entity\Routine;
use App\Entity\User;
use App\Factory\CompletedRoutineFactory;
use App\Form\Frontend\CompletedRoutineType;
use App\Manager\CompletedRoutineManager;
use App\Repository\QuoteRepository;
use App\Repository\ReminderRepository;
use App\Security\Voter\RoutineVoter;
use App\Service\EmailService;
use App\Service\RewardService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        EmailService $emailService,
        QuoteRepository $quoteRepository,
        ReminderRepository $reminderRepository,
        Request $request,
        RewardService $rewardService,
        Routine $routine,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);

        $completedRoutine = $completedRoutineFactory->createCompletedRoutine();
        $completedRoutine->setRoutine($routine);
        $completedRoutine->setUser($this->getUser());
        $form = $this->createForm(CompletedRoutineType::class, $completedRoutine);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $completedRoutineManager->save($completedRoutine, $this->getUser());

            $reward = $rewardService->manageReward($completedRoutine->getRoutine(), Reward::TYPE_COMPLETED_ROUTINE);

            $this->addFlash(
                'success',
                $translator->trans('Congratulations for completing your routine!')
            );

            if (true === $this->getUser()->getProfile()->getShowMotivationalMessages()) {
                $quote = $quoteRepository->findOneByStringLength();
                if (null !== $quote) {
                    $this->addFlash(
                        'primary',
                        (string) $quote
                    );
                }

                $quote = $quoteRepository->findOneByStringLength();
                $reminder = $reminderRepository->findOneByUser($this->getUser());
                $emailService->sendCompletedRoutineCongratulations(
                    $this->getUser()->getEmail(),
                    $translator->trans('R365: Congratulations for completing your routine!'),
                    [
                        'quote' => $quote,
                        'reminder' => $reminder,
                    ]
                );
            }

            if ((null !== $reward) && (true === $reward->getIsAwarded())) {
                $this->addFlash(
                    'success',
                    $translator->trans('Congratulations for awarding your reward!')
                );

                return $this->redirectToRoute('frontend_reward_show', [
                    'uuid' => $reward->getUuid(),
                ]);
            }

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
