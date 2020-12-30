<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Promotion;
use App\Entity\User;
use App\Factory\PromotionFactory;
use App\Form\Admin\PromotionType;
use App\Manager\PromotionManager;
use App\Repository\PromotionRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/promotion", name="admin_promotion_")
 */
class PromotionController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        PromotionRepository $promotionRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $promotionsQuery = $promotionRepository->findByParametersForAdmin($parameters);
        $promotions = $paginator->paginate(
            $promotionsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $promotions->getTotalItemCount();

        return $this->render('admin/promotion/index.html.twig', [
            'parameters' => $parameters,
            'promotions' => $promotions,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(
        PromotionFactory $promotionFactory,
        PromotionManager $promotionManager,
        Request $request
    ): Response {
        $promotion = $promotionFactory->createPromotion();
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $promotionManager->save($promotion, (string) $this->getUser());

            return $this->redirectToRoute('admin_promotion_show', [
                'uuid' => $promotion->getUuid(),
            ]);
        }

        return $this->render('admin/promotion/new.html.twig', [
            'form' => $form->createView(),
            'promotion' => $promotion,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Promotion $promotion): Response
    {
        return $this->render('admin/promotion/show.html.twig', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Promotion $promotion,
        PromotionManager $promotionManager,
        Request $request
    ): Response {
        $form = $this->createForm(PromotionType::class, $promotion);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $promotionManager->save($promotion, (string) $this->getUser());

            return $this->redirectToRoute('admin_promotion_show', [
                'uuid' => $promotion->getUuid(),
            ]);
        }

        return $this->render('admin/promotion/edit.html.twig', [
            'form' => $form->createView(),
            'promotion' => $promotion,
        ]);
    }

    /**
     * @IsGranted(User::ROLE_SUPER_ADMIN)
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Promotion $promotion,
        PromotionManager $promotionManager,
        Request $request
    ): Response {
        if (true === $this->isCsrfTokenValid(
            'delete'.(string) $promotion->getUuid(),
            $request->request->get('_token')
        )) {
            $promotionManager->softDelete($promotion, (string) $this->getUser());
        }

        return $this->redirectToRoute('admin_promotion_index');
    }

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
    public function undelete(
        Promotion $promotion,
        PromotionManager $promotionManager
    ): Response {
        $promotionManager->undelete($promotion);

        return $this->redirectToRoute('admin_promotion_show', [
            'uuid' => $promotion->getUuid(),
        ]);
    }
}
