<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\UserKpi;
use App\Manager\UserKpiManager;
use App\Repository\UserKpiRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 */
#[Route('/admin/user-kpi', name: 'admin_user_kpi_')]
class UserKpiController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        UserKpiRepository $userKpiRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $userKpisQuery = $userKpiRepository->findByParametersForAdmin($parameters);
        $userKpis = $paginator->paginate(
            $userKpisQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $userKpis->getTotalItemCount();

        return $this->render('admin/user_kpi/index.html.twig', [
            'parameters' => $parameters,
            'user_kpis' => $userKpis,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(UserKpi $userKpi): Response
    {
        return $this->render('admin/user_kpi/show.html.twig', [
            'user_kpi' => $userKpi,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        UserKpi $userKpi,
        UserKpiManager $userKpiManager
    ): Response {
        $userKpiManager->undelete($userKpi);

        return $this->redirectToRoute('admin_user_kpi_show', [
            'uuid' => $userKpi->getUuid(),
        ]);
    }
}
