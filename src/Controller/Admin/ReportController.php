<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Report;
use App\Entity\User;
use App\Manager\ReportManager;
use App\Repository\ReportRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_ADMIN)]
#[Route('/admin/report', name: 'admin_report_')]
class ReportController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        ReportRepository $reportRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'status' => trim((string) $request->query->get('status')),
            'type' => trim((string) $request->query->get('type')),
        ];

        $reportsQuery = $reportRepository->findByParametersForAdmin($parameters);
        $reports = $paginator->paginate(
            $reportsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $reports->getTotalItemCount();

        return $this->render('admin/report/index.html.twig', [
            'reports' => $reports,
            'parameters' => $parameters,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Report $report): Response
    {
        return $this->render('admin/report/show.html.twig', [
            'report' => $report,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Report $report,
        ReportManager $reportManager
    ): Response {
        $reportManager->undelete($report);

        return $this->redirectToRoute('admin_report_show', [
            'uuid' => $report->getUuid(),
        ]);
    }
}
