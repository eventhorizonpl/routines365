<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\{Achievement, Reward, Routine, User};
use App\Enum\{AchievementTypeEnum, RewardTypeEnum, UserRoleEnum};
use App\Factory\CompletedRoutineFactory;
use App\Form\Frontend\CompletedRoutineType;
use App\Manager\CompletedRoutineManager;
use App\Repository\{QuoteRepository, ReminderRepository};
use App\Resource\KytResource;
use App\Security\Voter\RoutineVoter;
use App\Service\{AchievementService, EmailService, RewardService};
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_USER->value)]
#[Route('/completed-routines', name: 'frontend_completed_routine_')]
class CompletedRoutineController extends AbstractController
{
    #[Route('/{uuid}/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        AchievementService $achievementService,
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
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));
        $user = $this->getUser();

        $completedRoutine = $completedRoutineFactory->createCompletedRoutine();
        $completedRoutine->setRoutine($routine);
        $completedRoutine->setUser($user);
        $user->addCompletedRoutine($completedRoutine);
        $form = $this->createForm(CompletedRoutineType::class, $completedRoutine);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $completedRoutineManager->save($completedRoutine, (string) $user);

            $reward = $rewardService->manageReward($completedRoutine->getRoutine(), RewardTypeEnum::COMPLETED_ROUTINE);
            $achievement = $achievementService->manageAchievements($user, AchievementTypeEnum::COMPLETED_ROUTINE);

            if (null !== $achievement) {
                $this->addFlash(
                    'success',
                    $translator->trans('Congratulations! You have a new achievement!')
                );
            }

            $this->addFlash(
                'success',
                $translator->trans('Congratulations for completing your routine!')
            );

            if (true === $user->getProfile()->getShowMotivationalMessages()) {
                $quote = $quoteRepository->findOneByStringLength();
                if (null !== $quote) {
                    $this->addFlash(
                        'primary',
                        (string) $quote
                    );
                }

                $quote = $quoteRepository->findOneByStringLength();
                $reminder = $reminderRepository->findOneByUser($user);
                $emailService->sendCompletedRoutineCongratulations(
                    $user->getEmail(),
                    $translator->trans('R365: Congratulations for completing your routine!'),
                    [
                        'quote' => $quote,
                        'recipient_first_name' => $user->getProfile()->getFirstName(),
                        'reminder' => $reminder,
                    ]
                );
            }

            if ((null !== $reward) && (true === $reward->getIsAwarded())) {
                $this->addFlash(
                    'success',
                    $translator->trans('Congratulations for awarding your reward!')
                );

                return $this->redirectToRoute(
                    'frontend_reward_show',
                    [
                        'uuid' => $reward->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }

            if ($knowYourTools) {
                return $this->redirectToRoute(
                    'frontend_routine_show',
                    [
                        'know_your_tools' => KytResource::COMPLETING_ROUTINES_FINISH,
                        'uuid' => $routine->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }

            return $this->redirectToRoute(
                'frontend_routine_show',
                [
                    'uuid' => $routine->getUuid(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('frontend/completed_routine/new.html.twig', [
            'completed_routine' => $completedRoutine,
            'form' => $form,
            'know_your_tools' => $knowYourTools,
            'routine' => $routine,
        ]);
    }
}
