<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Reward;
use App\Entity\User;
use App\Manager\RewardManager;
use App\Repository\RewardRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_ADMIN)]
#[Route('/admin/reward', name: 'admin_reward_')]
class RewardController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        RewardRepository $rewardRepository
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $rewardsQuery = $rewardRepository->findByParametersForAdmin($parameters);
        $rewards = $paginator->paginate(
            $rewardsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $rewards->getTotalItemCount();

        return $this->render('admin/reward/index.html.twig', [
            'parameters' => $parameters,
            'rewards' => $rewards,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Reward $reward): Response
    {
        return $this->render('admin/reward/show.html.twig', [
            'reward' => $reward,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Reward $reward,
        RewardManager $rewardManager
    ): Response {
        $rewardManager->undelete($reward);

        return $this->redirectToRoute('admin_reward_show', [
            'uuid' => $reward->getUuid(),
        ]);
    }
}
