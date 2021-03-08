<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\UserQuestionnaire;
use App\Manager\UserQuestionnaireManager;
use App\Repository\UserQuestionnaireRepository;
use App\Util\DateTimeImmutableUtil;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(User::ROLE_ADMIN)]
#[Route('/admin/user-questionnaire', name: 'admin_user_questionnaire_')]
class UserQuestionnaireController extends AbstractController
{
    #[Route('/', methods: ['GET'], name: 'index')]
    public function index(
        PaginatorInterface $paginator,
        UserQuestionnaireRepository $userQuestionnaireRepository,
        Request $request
    ): Response {
        $parameters = [
            'ends_at' => DateTimeImmutableUtil::endsAtFromString($request->query->get('ends_at')),
            'query' => trim((string) $request->query->get('q')),
            'starts_at' => DateTimeImmutableUtil::startsAtFromString($request->query->get('starts_at')),
        ];

        $userQuestionnairesQuery = $userQuestionnaireRepository->findByParametersForAdmin($parameters);
        $userQuestionnaires = $paginator->paginate(
            $userQuestionnairesQuery,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 50)
        );
        $parameters['count'] = $userQuestionnaires->getTotalItemCount();

        return $this->render('admin/user_questionnaire/index.html.twig', [
            'parameters' => $parameters,
            'user_questionnaires' => $userQuestionnaires,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(UserQuestionnaire $userQuestionnaire): Response
    {
        return $this->render('admin/user_questionnaire/show.html.twig', [
            'user_questionnaire' => $userQuestionnaire,
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        UserQuestionnaire $userQuestionnaire,
        UserQuestionnaireManager $userQuestionnaireManager
    ): Response {
        $userQuestionnaireManager->undelete($userQuestionnaire);

        return $this->redirectToRoute('admin_user_questionnaire_show', [
            'uuid' => $userQuestionnaire->getUuid(),
        ]);
    }
}
