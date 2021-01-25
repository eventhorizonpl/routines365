<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Factory\CronJobFactory;
use App\Form\Admin\CronJobType;
use App\Manager\CronJobManager;
use Cron\CronBundle\Entity\CronJob;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/cron-job", name="admin_cron_job_")
 */
class CronJobController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $cronJobsQuery = $this->getDoctrine()
            ->getRepository(CronJob::class)
            ->createQueryBuilder('cj')
            ->orderBy('cj.id', 'DESC')
            ->getQuery();
        $cronJobs = $paginator->paginate(
            $cronJobsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters = [
            'count' => $cronJobs->getTotalItemCount(),
        ];

        return $this->render('admin/cron_job/index.html.twig', [
            'cron_jobs' => $cronJobs,
            'parameters' => $parameters,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(
        CronJobFactory $cronJobFactory,
        CronJobManager $cronJobManager,
        Request $request
    ): Response {
        $cronJob = $cronJobFactory->createCronJob();
        $form = $this->createForm(CronJobType::class, $cronJob);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $cronJobManager->save($cronJob);

            return $this->redirectToRoute('admin_cron_job_show', [
                'id' => $cronJob->getId(),
            ]);
        }

        return $this->render('admin/cron_job/new.html.twig', [
            'cron_job' => $cronJob,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(CronJob $cronJob): Response
    {
        return $this->render('admin/cron_job/show.html.twig', [
            'cron_job' => $cronJob,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        CronJob $cronJob,
        CronJobManager $cronJobManager,
        Request $request
    ): Response {
        $form = $this->createForm(CronJobType::class, $cronJob);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $cronJobManager->save($cronJob);

            return $this->redirectToRoute('admin_cron_job_show', [
                'id' => $cronJob->getId(),
            ]);
        }

        return $this->render('admin/cron_job/edit.html.twig', [
            'cron_job' => $cronJob,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted(User::ROLE_SUPER_ADMIN)
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(
        CronJob $cronJob,
        CronJobManager $cronJobManager,
        Request $request
    ): Response {
        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $cronJob->getId()
            ),
            $request->request->get('_token')
        )) {
            $cronJobManager->delete($cronJob);
        }

        return $this->redirectToRoute('admin_cron_job_index');
    }
}
