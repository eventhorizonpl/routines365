<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Project;
use App\Entity\User;
use App\Factory\ProjectFactory;
use App\Form\Frontend\ProjectType;
use App\Manager\ProjectManager;
use App\Repository\ProjectRepository;
use App\Security\Voter\ProjectVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_USER)
 * @Route("/projects", name="frontend_project_")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(
        ProjectRepository $projectRepository,
        Request $request
    ): Response {
        $parameters = [
            'query' => trim($request->query->get('q')),
        ];

        $projects = $projectRepository->findByParametersForFrontend($this->getUser(), $parameters);

        return $this->render('frontend/project/index.html.twig', [
            'parameters' => $parameters,
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(
        ProjectFactory $projectFactory,
        ProjectManager $projectManager,
        Request $request
    ): Response {
        $project = $projectFactory->createProject();
        $project->setUser($this->getUser());
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $projectManager->save($project, $this->getUser());

            return $this->redirectToRoute('frontend_project_show', [
                'uuid' => $project->getUuid(),
            ]);
        }

        return $this->render('frontend/project/new.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Project $project): Response
    {
        $this->denyAccessUnlessGranted(ProjectVoter::VIEW, $project);

        return $this->render('frontend/project/show.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Project $project,
        ProjectManager $projectManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(ProjectVoter::EDIT, $project);

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $projectManager->save($project, $this->getUser());

            return $this->redirectToRoute('frontend_project_show', [
                'uuid' => $project->getUuid(),
            ]);
        }

        return $this->render('frontend/project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
    public function delete(
        Project $project,
        ProjectManager $projectManager,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted(ProjectVoter::DELETE, $project);

        if (true === $this->isCsrfTokenValid(
            'delete'.$project->getUuid(),
            $request->request->get('_token')
        )) {
            $projectManager->softDelete($project, $this->getUser());
        }

        return $this->redirectToRoute('frontend_project_index');
    }
}
