<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Reward;
use App\Entity\Routine;
use App\Entity\User;
use App\Factory\RewardFactory;
use App\Form\Frontend\RewardType;
use App\Manager\RewardManager;
use App\Repository\RewardRepository;
use App\Security\Voter\RewardVoter;
use App\Security\Voter\RoutineVoter;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/rewards", name="frontend_reward_")
 */
class RewardController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        RewardRepository $rewardRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
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
            'parameters' => $parameters,
            'rewards' => $rewards,
        ]);
    }

    /**
     * @Route("/new/{uuid?}", name="new", methods={"GET","POST"})
     */
    public function new(
        Request $request,
        RewardFactory $rewardFactory,
        RewardManager $rewardManager,
        Routine $routine = null
    ): Response {
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

            return $this->redirectToRoute('frontend_reward_show', [
                'uuid' => $reward->getUuid(),
            ]);
        }

        return $this->render('frontend/reward/new.html.twig', [
            'form' => $form->createView(),
            'reward' => $reward,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Reward $reward): Response
    {
        $this->denyAccessUnlessGranted(RewardVoter::VIEW, $reward);

        return $this->render('frontend/reward/show.html.twig', [
            'reward' => $reward,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Reward $reward,
        RewardManager $rewardManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(RewardVoter::EDIT, $reward);

        $form = $this->createForm(RewardType::class, $reward);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $rewardManager->save($reward, (string) $this->getUser());

            return $this->redirectToRoute('frontend_reward_show', [
                'uuid' => $reward->getUuid(),
            ]);
        }

        return $this->render('frontend/reward/edit.html.twig', [
            'form' => $form->createView(),
            'reward' => $reward,
        ]);
    }

    /**
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Reward $reward,
        RewardManager $rewardManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(RewardVoter::DELETE, $reward);

        if (true === $this->isCsrfTokenValid(
            'delete'.$reward->getUuid(),
            $request->request->get('_token')
        )) {
            $rewardManager->softDelete($reward, (string) $this->getUser());
        }

        return $this->redirectToRoute('frontend_reward_index');
    }
}
