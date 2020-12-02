<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Kpi;
use App\Entity\User;
use App\Manager\KpiManager;
use App\Repository\KpiRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/kpi", name="admin_kpi_")
 */
class KpiController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        KpiRepository $kpiRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $kpisQuery = $kpiRepository->findByParametersForAdmin($parameters);
        $kpis = $paginator->paginate(
            $kpisQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $kpis->getTotalItemCount();

        return $this->render('admin/kpi/index.html.twig', [
            'kpis' => $kpis,
            'parameters' => $parameters,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Kpi $kpi): Response
    {
        return $this->render('admin/kpi/show.html.twig', [
            'kpi' => $kpi,
        ]);
    }

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
    public function undelete(
        Kpi $kpi,
        KpiManager $kpiManager
    ): Response {
        $kpiManager->undelete($kpi);

        return $this->redirectToRoute('admin_kpi_show', [
            'uuid' => $kpi->getUuid(),
        ]);
    }
}
