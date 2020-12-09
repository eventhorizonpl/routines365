<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Achievement;
use App\Entity\User;
use App\Factory\AchievementFactory;
use App\Form\Admin\AchievementType;
use App\Manager\AchievementManager;
use App\Repository\AchievementRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/achievement", name="admin_achievement_")
 */
class AchievementController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        AchievementRepository $achievementRepository,
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
            'parameters' => $parameters,
            'achievements' => $achievements,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
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

            return $this->redirectToRoute('admin_achievement_show', [
                'uuid' => $achievement->getUuid(),
            ]);
        }

        return $this->render('admin/achievement/new.html.twig', [
            'form' => $form->createView(),
            'achievement' => $achievement,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Achievement $achievement): Response
    {
        return $this->render('admin/achievement/show.html.twig', [
            'achievement' => $achievement,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Achievement $achievement,
        AchievementManager $achievementManager,
        Request $request
    ): Response {
        $form = $this->createForm(AchievementType::class, $achievement);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $achievementManager->save($achievement, (string) $this->getUser());

            return $this->redirectToRoute('admin_achievement_show', [
                'uuid' => $achievement->getUuid(),
            ]);
        }

        return $this->render('admin/achievement/edit.html.twig', [
            'form' => $form->createView(),
            'achievement' => $achievement,
        ]);
    }

    /**
     * @IsGranted(User::ROLE_SUPER_ADMIN)
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Achievement $achievement,
        AchievementManager $achievementManager,
        Request $request
    ): Response {
        if (true === $this->isCsrfTokenValid(
            'delete'.$achievement->getUuid(),
            $request->request->get('_token')
        )) {
            $achievementManager->softDelete($achievement, (string) $this->getUser());
        }

        return $this->redirectToRoute('admin_achievement_index');
    }

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
    public function undelete(
        Achievement $achievement,
        AchievementManager $achievementManager
    ): Response {
        $achievementManager->undelete($achievement);

        return $this->redirectToRoute('admin_achievement_show', [
            'uuid' => $achievement->getUuid(),
        ]);
    }
}
