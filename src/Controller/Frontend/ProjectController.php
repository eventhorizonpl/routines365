<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\Achievement;
use App\Entity\Project;
use App\Entity\User;
use App\Factory\ProjectFactory;
use App\Form\Frontend\ProjectType;
use App\Manager\ProjectManager;
use App\Repository\ProjectRepository;
use App\Resource\KytResource;
use App\Security\Voter\ProjectVoter;
use App\Service\AchievementService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $parameters = [
            'query' => trim((string) $request->query->get('q')),
        ];

        $projects = $projectRepository->findByParametersForFrontend($this->getUser(), $parameters);

        return $this->render('frontend/project/index.html.twig', [
            'know_your_tools' => $knowYourTools,
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
        $user = $this->getUser();
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        $project = $projectFactory->createProject();
        $project->setUser($user);
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $projectManager->save($project, (string) $user);

            if ($knowYourTools) {
                return $this->redirectToRoute('frontend_project_show', [
                    'know_your_tools' => KytResource::PROJECTS_SHOW,
                    'uuid' => $project->getUuid(),
                ]);
            } else {
                return $this->redirectToRoute('frontend_project_show', [
                    'uuid' => $project->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/project/new.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Project $project, Request $request): Response
    {
        $this->denyAccessUnlessGranted(ProjectVoter::VIEW, $project);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));

        return $this->render('frontend/project/show.html.twig', [
            'know_your_tools' => $knowYourTools,
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        AchievementService $achievementService,
        Project $project,
        ProjectManager $projectManager,
        Request $request,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted(ProjectVoter::EDIT, $project);
        $knowYourTools = trim((string) $request->query->get('know_your_tools'));
        $user = $this->getUser();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $projectManager->save($project, (string) $user);
            $achievement = $achievementService->manageAchievements($user, Achievement::TYPE_COMPLETED_PROJECT);

            if (null !== $achievement) {
                $this->addFlash(
                    'success',
                    $translator->trans('Congratulations! You have a new achievement!')
                );
            }

            if ($knowYourTools) {
                return $this->redirectToRoute('frontend_project_show', [
                    'know_your_tools' => KytResource::PROJECTS_FINISH,
                    'uuid' => $project->getUuid(),
                ]);
            } else {
                return $this->redirectToRoute('frontend_project_show', [
                    'uuid' => $project->getUuid(),
                ]);
            }
        }

        return $this->render('frontend/project/edit.html.twig', [
            'form' => $form->createView(),
            'know_your_tools' => $knowYourTools,
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
            sprintf(
                'delete%s',
                (string) $project->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $projectManager->softDelete($project, (string) $this->getUser());
        }

        return $this->redirectToRoute('frontend_project_index');
    }
}
