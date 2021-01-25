<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\User;
use App\Factory\QuestionFactory;
use App\Form\Admin\QuestionType;
use App\Manager\QuestionManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted(User::ROLE_ADMIN)
 * @Route("/admin/question", name="admin_question_")
 */
class QuestionController extends AbstractController
{
    /**
     * @Route("/new/{uuid}", name="new", methods={"GET","POST"})
     */
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

            return $this->redirectToRoute('admin_questionnaire_show', [
                'uuid' => $questionnaire->getUuid(),
            ]);
        }

        return $this->render('admin/question/new.html.twig', [
            'form' => $form->createView(),
            'question' => $question,
        ]);
    }

    /**
     * @Route("/{uuid}", name="show", methods={"GET"})
     */
    public function show(Question $question): Response
    {
        return $this->render('admin/question/show.html.twig', [
            'question' => $question,
        ]);
    }

    /**
     * @Route("/{uuid}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(
        Question $question,
        QuestionManager $questionManager,
        Request $request
    ): Response {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ((true === $form->isSubmitted()) && (true === $form->isValid())) {
            $questionManager->save($question, (string) $this->getUser());

            return $this->redirectToRoute('admin_question_show', [
                'uuid' => $question->getUuid(),
            ]);
        }

        return $this->render('admin/question/edit.html.twig', [
            'form' => $form->createView(),
            'question' => $question,
        ]);
    }

    /**
     * @IsGranted(User::ROLE_SUPER_ADMIN)
     * @Route("/{uuid}", name="delete", methods={"DELETE"})
     */
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

        return $this->redirectToRoute('admin_questionnaire_show', [
            'uuid' => $question->getQuestionnaire()->getUuid(),
        ]);
    }

    /**
     * @Route("/{uuid}/undelete", name="undelete", methods={"GET"})
     */
    public function undelete(
        Question $question,
        QuestionManager $questionManager
    ): Response {
        $questionManager->undelete($question);

        return $this->redirectToRoute('admin_question_show', [
            'uuid' => $question->getUuid(),
        ]);
    }
}
