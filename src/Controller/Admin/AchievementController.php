<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{Achievement, User};
use App\Enum\UserRoleEnum;
use App\Factory\AchievementFactory;
use App\Form\Admin\AchievementType;
use App\Manager\AchievementManager;
use App\Repository\AchievementRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_ADMIN)]
#[Route('/admin/achievement', name: 'admin_achievement_')]
class AchievementController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        AchievementRepository $achievementRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $achievementsQuery = $achievementRepository->findByParametersForAdmin($parameters);
        $achievements = $paginator->paginate(
            $achievementsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $achievements->getTotalItemCount();

        return $this->render('admin/achievement/index.html.twig', [
            'achievements' => $achievements,
            'parameters' => $parameters,
        ]);
    }

    #[Route('/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        AchievementFactory $achievementFactory,
        AchievementManager $achievementManager,
        Request $request
    ): Response {
        $achievement = $achievementFactory->createAchievement();
        $form = $this->createForm(AchievementType::class, $achievement);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $achievementManager->save($achievement, (string) $this->getUser());

            return $this->redirectToRoute(
                'admin_achievement_show',
                [
                    'uuid' => $achievement->getUuid(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/achievement/new.html.twig', [
            'achievement' => $achievement,
            'form' => $form,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Achievement $achievement): Response
    {
        return $this->render('admin/achievement/show.html.twig', [
            'achievement' => $achievement,
        ]);
    }

    #[Route('/{uuid}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        Achievement $achievement,
        AchievementManager $achievementManager,
        Request $request
    ): Response {
        $form = $this->createForm(AchievementType::class, $achievement);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $achievementManager->save($achievement, (string) $this->getUser());

            return $this->redirectToRoute(
                'admin_achievement_show',
                [
                    'uuid' => $achievement->getUuid(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/achievement/edit.html.twig', [
            'achievement' => $achievement,
            'form' => $form,
        ]);
    }

    #[IsGranted(UserRoleEnum::ROLE_SUPER_ADMIN)]
    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        Achievement $achievement,
        AchievementManager $achievementManager,
        Request $request
    ): Response {
        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $achievement->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $achievementManager->softDelete($achievement, (string) $this->getUser());
        }

        return $this->redirectToRoute('admin_achievement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Achievement $achievement,
        AchievementManager $achievementManager
    ): Response {
        $achievementManager->undelete($achievement);

        return $this->redirectToRoute(
            'admin_achievement_show',
            [
                'uuid' => $achievement->getUuid(),
            ],
            Response::HTTP_SEE_OTHER
        );
    }
}
