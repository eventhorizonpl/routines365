<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\{Answer, Question, User};
use App\Enum\UserRoleEnum;
use App\Factory\AnswerFactory;
use App\Form\Admin\AnswerType;
use App\Manager\AnswerManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted(UserRoleEnum::ROLE_ADMIN)]
#[Route('/admin/answer', name: 'admin_answer_')]
class AnswerController extends AbstractController
{
    #[Route('/new/{uuid}', methods: ['GET', 'POST'], name: 'new')]
    public function new(
        AnswerFactory $answerFactory,
        AnswerManager $answerManager,
        Question $question,
        Request $request
    ): Response {
        $answer = $answerFactory->createAnswer();
        $answer->setQuestion($question);
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $answerManager->save($answer, (string) $this->getUser());

            return $this->redirectToRoute('admin_answer_show', [
                'uuid' => $answer->getUuid(),
            ]);
        }

        return $this->render('admin/answer/new.html.twig', [
            'form' => $form->createView(),
            'answer' => $answer,
        ]);
    }

    #[Route('/{uuid}', methods: ['GET'], name: 'show')]
    public function show(Answer $answer): Response
    {
        return $this->render('admin/answer/show.html.twig', [
            'answer' => $answer,
        ]);
    }

    #[Route('/{uuid}/edit', methods: ['GET', 'POST'], name: 'edit')]
    public function edit(
        Answer $answer,
        AnswerManager $answerManager,
        Request $request
    ): Response {
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $answerManager->save($answer, (string) $this->getUser());

            return $this->redirectToRoute('admin_answer_show', [
                'uuid' => $answer->getUuid(),
            ]);
        }

        return $this->render('admin/answer/edit.html.twig', [
            'form' => $form->createView(),
            'answer' => $answer,
        ]);
    }

    #[IsGranted(UserRoleEnum::ROLE_SUPER_ADMIN)]
    #[Route('/{uuid}', methods: ['DELETE'], name: 'delete')]
    public function delete(
        Answer $answer,
        AnswerManager $answerManager,
        Request $request
    ): Response {
        if (true === $this->isCsrfTokenValid(
            sprintf(
                'delete%s',
                (string) $answer->getUuid()
            ),
            $request->request->get('_token')
        )) {
            $answerManager->softDelete($answer, (string) $this->getUser());
        }

        return $this->redirectToRoute('admin_question_show', [
            'uuid' => $answer->getQuestion()->getUuid(),
        ]);
    }

    #[Route('/{uuid}/undelete', methods: ['GET'], name: 'undelete')]
    public function undelete(
        Answer $answer,
        AnswerManager $answerManager
    ): Response {
        $answerManager->undelete($answer);

        return $this->redirectToRoute('admin_answer_show', [
            'uuid' => $answer->getUuid(),
        ]);
    }
}
