<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Achievement;
use App\Entity\Goal;
use App\Entity\Reward;
use App\Entity\User;
use App\Factory\GoalFactory;
use App\Form\Frontend\GoalType;
use App\Manager\GoalManager;
use App\Repository\ProjectRepository;
use App\Repository\QuoteRepository;
use App\Repository\RoutineRepository;
use App\Resource\KytResource;
use App\Security\Voter\GoalVoter;
use App\Security\Voter\ProjectVoter;
use App\Security\Voter\RoutineVoter;
use App\Service\AchievementService;
use App\Service\RewardService;
use DateTimeImmutable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(User::ROLE_USER)]
#[Route('/goals', name: 'frontend_goal_')]
class GoalController extends AbstractController
{
    #[Route('/{uuid}/{context}/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        string $context,
        GoalFactory $goalFactory,
        GoalManager $goalManager,
        ProjectRepository $projectRepository,
        Request $request,
        RoutineRepository $routineRepository,
        string $uuid
    ): Response {
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));
        $goal = $goalFactory->createGoal();
        $project = null;
        $routine = null;

        if (Goal::CONTEXT_PROJECT === $context) {
            $project = $projectRepository->findOneByUuid($uuid);
            if (null === $project) {
                throw $this->createNotFoundException();
            }
            $this->denyAccessUnlessGranted(ProjectVoter::EDIT, $project);
            $goal->setProject($project);
        } elseif (Goal::CONTEXT_ROUTINE === $context) {
            $routine = $routineRepository->findOneByUuid($uuid);
            if (null === $routine) {
                throw $this->createNotFoundException();
            }
            $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);
            $goal->setRoutine($routine);
        }

        $goal->setUser($this->getUser());
        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $goalManager->save($goal, (string) $this->getUser());

            if ((Goal::CONTEXT_PROJECT === $context) && (null !== $goal->getProject())) {
                return $this->redirectToRoute('frontend_project_show', [
                    'uuid' => $goal->getProject()->getUuid(),
                ]);
            }
            if ((Goal::CONTEXT_ROUTINE === $context) || (null === $goal->getProject())) {
                if ($knowYourTools) {
                    return $this->redirectToRoute('frontend_routine_show_goals', [
                        'know_your_tools' => KytResource::GOALS_SHOW3,
                        'uuid' => $goal->getRoutine()->getUuid(),
                    ]);
                }

                return $this->redirectToRoute('frontend_routine_show_goals', [
                    'uuid' => $goal->getRoutine()->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/goal/new.html.twig', [
            'form' => $form->createView(),
            'goal' => $goal,
            'know_your_tools' => $knowYourTools,
            'project' => $project,
            'routine' => $routine,
        ]);
    }

    #[Route('/{uuid}/{context}/complete', methods: ['GET'], name: 'complete')]
    public function complete(
        AchievementService $achievementService,
        string $context,
        Goal $goal,
        GoalManager $goalManager,
        QuoteRepository $quoteRepository,
        Request $request,
        RewardService $rewardService,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted(GoalVoter::EDIT, $goal);
        $user = $this->getUser();

        $goal->setCompletedAt(new DateTimeImmutable());
        $goal->setIsCompleted(true);
        $goalManager->save($goal, (string) $user);

        $reward = $rewardService->manageReward($goal->getRoutine(), Reward::TYPE_COMPLETED_GOAL);
        $achievement = $achievementService->manageAchievements($user, Achievement::TYPE_COMPLETED_GOAL);

        if (null !== $achievement) {
            $this->addFlash(
                'success',
                $translator->trans('Congratulations! You have a new achievement!')
            );
        }

        $this->addFlash(
            'success',
            $translator->trans('Congratulations for achieving your goal!')
        );

        $quote = $quoteRepository->findOneByStringLength();
        if (null !== $quote) {
            $this->addFlash(
                'primary',
                (string) $quote
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

        if ((Goal::CONTEXT_PROJECT === $context) && (null !== $goal->getProject())) {
            return $this->redirectToRoute('frontend_project_show', [
                'uuid' => $goal->getProject()->getUuid(),
            ]);
        }
        if ((Goal::CONTEXT_ROUTINE === $context) || (null === $goal->getProject())) {
            return $this->redirectToRoute('frontend_routine_show_goals', [
                'uuid' => $goal->getRoutine()->getUuid(),
            ]);
        }
    }

    #[Route('/{uuid}/{context}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        string $context,
        Goal $goal,
        GoalManager $goalManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(GoalVoter::EDIT, $goal);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $form = $this->createForm(GoalType::class, $goal);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $goalManager->save($goal, (string) $this->getUser());

            if ((Goal::CONTEXT_PROJECT === $context) && (null !== $goal->getProject())) {
                return $this->redirectToRoute('frontend_project_show', [
                    'uuid' => $goal->getProject()->getUuid(),
                ]);
            }
            if ((Goal::CONTEXT_ROUTINE === $context) || (null === $goal->getProject())) {
                if ($knowYourTools) {
                    return $this->redirectToRoute('frontend_routine_show_goals', [
                        'know_your_tools' => KytResource::GOALS_FINISH,
                        'uuid' => $goal->getRoutine()->getUuid(),
                    ]);
                }

                return $this->redirectToRoute('frontend_routine_show_goals', [
                    'uuid' => $goal->getRoutine()->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/goal/edit.html.twig', [
            'context' => $context,
            'form' => $form->createView(),
            'goal' => $goal,
            'know_your_tools' => $knowYourTools,
            'project' => $goal->getProject(),
            'routine' => $goal->getRoutine(),
        ]);
    }

    #[Route('/{uuid}/{context}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        string $context,
        Goal $goal,
        GoalManager $goalManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(GoalVoter::DELETE, $goal);

        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $goal->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $goalManager->softDelete($goal, (string) $this->getUser());
        }

        if ((Goal::CONTEXT_PROJECT === $context) && (null !== $goal->getProject())) {
            return $this->redirectToRoute('frontend_project_show', [
                'uuid' => $goal->getProject()->getUuid(),
            ]);
        }
        if ((Goal::CONTEXT_ROUTINE === $context) || (null === $goal->getProject())) {
            return $this->redirectToRoute('frontend_routine_show_goals', [
                'uuid' => $goal->getRoutine()->getUuid(),
            ]);
        }
    }
}
