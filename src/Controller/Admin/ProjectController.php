<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Entity\User;
use App\Manager\ProjectManager;
use App\Repository\ProjectRepository;
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
#[Route('/admin/project', name: 'admin_project_')]
class ProjectController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        ProjectRepository $projectRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
            'type' => $request->query->get('type'),
        ];

        $projectsQuery = $projectRepository->findByParametersForAdmin($parameters);
        $projects = $paginator->paginate(
            $projectsQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $projects->getTotalItemCount();

        return $this->render('admin/project/index.html.twig', [
            'parameters' => $parameters,
            'projects' => $projects,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Project $project): Response
    {
        return $this->render('admin/project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Project $project,
        ProjectManager $projectManager
    ): Response {
        $projectManager->undelete($project);

        return $this->redirectToRoute('admin_project_show', [
            'uuid' => $project->getUuid(),
        ]);
    }
}
