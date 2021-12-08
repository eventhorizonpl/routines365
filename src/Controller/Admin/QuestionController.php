<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{Question, Questionnaire, User};
use App\Enum\UserRoleEnum;
use App\Factory\QuestionFactory;
use App\Form\Admin\QuestionType;
use App\Manager\QuestionManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_ADMIN)]
#[Route('/admin/question', name: 'admin_question_')]
class QuestionController extends AbstractController
{
    #[Route('/new/{uuid}', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        QuestionFactory $questionFactory,
        QuestionManager $questionManager,
        Questionnaire $questionnaire,
        Request $request
    ): Response {
        $question = $questionFactory->createQuestion();
        $question->setQuestionnaire($questionnaire);
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $questionManager->save($question, (string) $this->getUser());

            return $this->redirectToRoute(
                'admin_questionnaire_show',
                [
                    'uuid' => $questionnaire->getUuid(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/question/new.html.twig', [
            'form' => $form,
            'question' => $question,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Question $question): Response
    {
        return $this->render('admin/question/show.html.twig', [
            'question' => $question,
        ]);
    }

    #[Route('/{uuid}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        Question $question,
        QuestionManager $questionManager,
        Request $request
    ): Response {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $questionManager->save($question, (string) $this->getUser());

            return $this->redirectToRoute(
                'admin_question_show',
                [
                    'uuid' => $question->getUuid(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->renderForm('admin/question/edit.html.twig', [
            'form' => $form,
            'question' => $question,
        ]);
    }

    #[IsGranted(UserRoleEnum::ROLE_SUPER_ADMIN)]
    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        Question $question,
        QuestionManager $questionManager,
        Request $request
    ): Response {
        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $question->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $questionManager->softDelete($question, (string) $this->getUser());
        }

        return $this->redirectToRoute(
            'admin_questionnaire_show',
            [
                'uuid' => $question->getQuestionnaire()->getUuid(),
            ],
            Response::HTTP_SEE_OTHER
        );
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Question $question,
        QuestionManager $questionManager
    ): Response {
        $questionManager->undelete($question);

        return $this->redirectToRoute(
            'admin_question_show',
            [
                'uuid' => $question->getUuid(),
            ],
            Response::HTTP_SEE_OTHER
        );
    }
}
