<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\{Questionnaire, User};
use App\Enum\UserRoleEnum;
use App\Manager\QuestionnaireManager;
use App\Security\Voter\QuestionnaireVoter;
use App\Service\UserQuestionnaireService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(UserRoleEnum::ROLE_USER)]
#[Route('/surveys', name: 'frontend_survey_')]
class QuestionnaireController extends AbstractController
{
    #[Route('/{uuid}', methods: ['GET', 'POST'], name: 'complete')]
    public function complete(
        Questionnaire $questionnaire,
        QuestionnaireManager $questionnaireManager,
        Request $request,
        UserQuestionnaireService $userQuestionnaireService,
        TranslatorInterface $translator
    ): Response {
        $this->denyAccessUnlessGranted(QuestionnaireVoter::COMPLETE, $questionnaire);
        $user = $this->getUser();
        $userQuestionnaire = $userQuestionnaireService->findOrCreate($questionnaire, $user);

        if (true === $userQuestionnaire->getIsCompleted()) {
            $this->addFlash(
                'success',
                $translator->trans('You already completed this survey.')
            );

            return $this->redirectToRoute('frontend_home', [], Response::HTTP_SEE_OTHER);
        }

        if ('POST' === $request->getMethod()) {
            $userQuestionnaire = $userQuestionnaireService->updateUserQuestionnaire(
                $request->request,
                $questionnaire,
                $userQuestionnaire
            );

            $this->addFlash(
                'success',
                $translator->trans('Thank you for completing this survey!')
            );

            if (false === $userQuestionnaire->getIsRewarded()) {
                $userQuestionnaire = $userQuestionnaireService->rewardUserQuestionnaire($userQuestionnaire);
                if (true === $userQuestionnaire->getIsRewarded()) {
                    $this->addFlash(
                        'success',
                        $translator->trans('We added a small reward to your account.')
                    );
                }
            }

            return $this->redirectToRoute('frontend_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('frontend/questionnaire/complete.html.twig', [
            'questionnaire' => $questionnaire,
        ]);
    }
}
