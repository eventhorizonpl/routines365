<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Cron\CronBundle\Entity\CronReport;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/cron-report", name="admin_cron_report_")
 */
class CronReportController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $cronReportsQuery = $this->getDoctrine()
            ->getRepository(CronReport::class)
            ->createQueryBuilder('cr')
            ->orderBy('cr.id', 'DESC')
            ->getQuery();
        $cronReports = $paginator->paginate(
            $cronReportsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );

        return $this->render('admin/cron_report/index.html.twig', [
            'cron_reports' => $cronReports,
        ]);
    }
}
