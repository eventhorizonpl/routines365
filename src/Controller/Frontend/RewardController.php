<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\{Reward, Routine, User};
use App\Enum\UserRoleEnum;
use App\Factory\RewardFactory;
use App\Form\Frontend\RewardType;
use App\Manager\RewardManager;
use App\Repository\RewardRepository;
use App\Resource\KytResource;
use App\Security\Voter\{RewardVoter, RoutineVoter};
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_USER->value)]
#[Route('/rewards', name: 'frontend_reward_')]
class RewardController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        RewardRepository $rewardRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $rewardsQuery = $rewardRepository->findByParametersForFrontend($this->getUser(), $parameters);
        $rewards = $paginator->paginate(
            $rewardsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('frontend/reward/index.html.twig', [
            'know_your_tools' => $knowYourTools,
            'parameters' => $parameters,
            'rewards' => $rewards,
        ]);
    }

    #[Route('/new/{context}/{uuid?}', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        string $context,
        Request $request,
        RewardFactory $rewardFactory,
        RewardManager $rewardManager,
        Routine $routine = null
    ): Response {
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $reward = $rewardFactory->createReward();
        if (null !== $routine) {
            $this->denyAccessUnlessGranted(RoutineVoter::EDIT, $routine);
            $reward->setRoutine($routine);
        }
        $reward->setUser($this->getUser());
        $form = $this->createForm(RewardType::class, $reward);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $rewardManager->save($reward, (string) $this->getUser());

            if (Reward::CONTEXT_DEFAULT === $context) {
                if ($knowYourTools) {
                    return $this->redirectToRoute(
                        'frontend_reward_show',
                        [
                            'know_your_tools' => KytResource::REWARDS_SHOW,
                            'uuid' => $reward->getUuid(),
                        ],
                        Response::HTTP_SEE_OTHER
                    );
                }

                return $this->redirectToRoute(
                    'frontend_reward_show',
                    [
                        'uuid' => $reward->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }
            if (Reward::CONTEXT_ROUTINE === $context) {
                return $this->redirectToRoute(
                    'frontend_routine_show_rewards',
                    [
                        'uuid' => $reward->getRoutine()->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }
        }

        return $this->renderForm('frontend/reward/new.html.twig', [
            'form' => $form,
            'know_your_tools' => $knowYourTools,
            'reward' => $reward,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Request $request, Reward $reward): Response
    {
        $this->denyAccessUnlessGranted(RewardVoter::VIEW, $reward);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        return $this->render('frontend/reward/show.html.twig', [
            'know_your_tools' => $knowYourTools,
            'reward' => $reward,
        ]);
    }

    #[Route('/{uuid}/{context}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        string $context,
        Reward $reward,
        RewardManager $rewardManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(RewardVoter::EDIT, $reward);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $form = $this->createForm(RewardType::class, $reward);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $rewardManager->save($reward, (string) $this->getUser());

            if (Reward::CONTEXT_DEFAULT === $context) {
                if ($knowYourTools) {
                    return $this->redirectToRoute(
                        'frontend_reward_show',
                        [
                            'know_your_tools' => KytResource::REWARDS_FINISH,
                            'uuid' => $reward->getUuid(),
                        ],
                        Response::HTTP_SEE_OTHER
                    );
                }

                return $this->redirectToRoute(
                    'frontend_reward_show',
                    [
                        'uuid' => $reward->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }
            if (Reward::CONTEXT_ROUTINE === $context) {
                return $this->redirectToRoute(
                    'frontend_routine_show_rewards',
                    [
                        'uuid' => $reward->getRoutine()->getUuid(),
                    ],
                    Response::HTTP_SEE_OTHER
                );
            }
        }

        return $this->renderForm('frontend/reward/edit.html.twig', [
            'form' => $form,
            'know_your_tools' => $knowYourTools,
            'reward' => $reward,
        ]);
    }

    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        Reward $reward,
        RewardManager $rewardManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(RewardVoter::DELETE, $reward);

        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $reward->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $rewardManager->softDelete($reward, (string) $this->getUser());
        }

        return $this->redirectToRoute('frontend_reward_index', [], Response::HTTP_SEE_OTHER);
    }
}
