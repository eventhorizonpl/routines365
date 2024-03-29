<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{Questionnaire, User};
use App\Enum\UserRoleEnum;
use App\Factory\QuestionnaireFactory;
use App\Form\Admin\QuestionnaireType;
use App\Manager\QuestionnaireManager;
use App\Repository\QuestionnaireRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_ADMIN)]
#[Route('/admin/questionnaire', name: 'admin_questionnaire_')]
class QuestionnaireController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        QuestionnaireRepository $questionnaireRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $questionnairesQuery = $questionnaireRepository->findByParametersForAdmin($parameters);
        $questionnaires = $paginator->paginate(
            $questionnairesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $questionnaires->getTotalItemCount();

        return $this->render('admin/questionnaire/index.html.twig', [
            'parameters' => $parameters,
            'questionnaires' => $questionnaires,
        ]);
    }

    #[Route('/new', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        QuestionnaireFactory $questionnaireFactory,
        QuestionnaireManager $questionnaireManager,
        Request $request
    ): Response {
        $questionnaire = $questionnaireFactory->createQuestionnaire();
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $questionnaireManager->save($questionnaire, (string) $this->getUser());

            return $this->redirectToRoute(
                'admin_questionnaire_show',
                [
                    'uuid' => $questionnaire->getUuid(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/questionnaire/new.html.twig', [
            'form' => $form,
            'questionnaire' => $questionnaire,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Questionnaire $questionnaire): Response
    {
        return $this->render('admin/questionnaire/show.html.twig', [
            'questionnaire' => $questionnaire,
        ]);
    }

    #[Route('/{uuid}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        Questionnaire $questionnaire,
        QuestionnaireManager $questionnaireManager,
        Request $request
    ): Response {
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $questionnaireManager->save($questionnaire, (string) $this->getUser());

            return $this->redirectToRoute(
                'admin_questionnaire_show',
                [
                    'uuid' => $questionnaire->getUuid(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/questionnaire/edit.html.twig', [
            'form' => $form,
            'questionnaire' => $questionnaire,
        ]);
    }

    #[IsGranted(UserRoleEnum::ROLE_SUPER_ADMIN)]
    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        Questionnaire $questionnaire,
        QuestionnaireManager $questionnaireManager,
        Request $request
    ): Response {
        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $questionnaire->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $questionnaireManager->softDelete($questionnaire, (string) $this->getUser());
        }

        return $this->redirectToRoute('admin_questionnaire_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Questionnaire $questionnaire,
        QuestionnaireManager $questionnaireManager
    ): Response {
        $questionnaireManager->undelete($questionnaire);

        return $this->redirectToRoute(
            'admin_questionnaire_show',
            [
                'uuid' => $questionnaire->getUuid(),
            ],
            Response::HTTP_SEE_OTHER
        );
    }
}
