<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\{Answer, Questionnaire, User, UserQuestionnaire};
use App\Enum\AnswerTypeEnum;
use App\Factory\UserQuestionnaireFactory;
use App\Manager\UserQuestionnaireManager;
use App\Repository\UserQuestionnaireRepository;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserQuestionnaireService
{
    public function __construct(
        private PromotionService $promotionService,
        private UserQuestionnaireAnswerService $userQuestionnaireAnswerService,
        private UserQuestionnaireFactory $userQuestionnaireFactory,
        private UserQuestionnaireManager $userQuestionnaireManager,
        private UserQuestionnaireRepository $userQuestionnaireRepository
    ) {
    }

    public function findOrCreate(Questionnaire $questionnaire, User $user): UserQuestionnaire
    {
        $userQuestionnaire = $this->userQuestionnaireRepository->findOneBy([
            'questionnaire' => $questionnaire,
            'user' => $user,
        ]);

        if (null === $userQuestionnaire) {
            $userQuestionnaire = $this->userQuestionnaireFactory->createUserQuestionnaireWithRequired(false);
            $userQuestionnaire->setQuestionnaire($questionnaire);
            $userQuestionnaire->setUser($user);
            $this->userQuestionnaireManager->save($userQuestionnaire, (string) $user);
        }

        return $userQuestionnaire;
    }

    public function updateUserQuestionnaire(
        ParameterBag $parameterBag,
        Questionnaire $questionnaire,
        UserQuestionnaire $userQuestionnaire
    ): UserQuestionnaire {
        foreach ($questionnaire->getQuestions() as $question) {
            $answerUuid = $parameterBag->get($question->getUuid());
            foreach ($question->getAnswers() as $answer) {
                if ($answer->getUuid() === $answerUuid) {
                    $content = null;
                    if (AnswerTypeEnum::OWN === $answer->getType()) {
                        $content = $parameterBag->get(sprintf(
                            '%s_%s_%s',
                            $question->getUuid(),
                            $answer->getUuid(),
                            AnswerTypeEnum::OWN
                        ));
                    }
                    $userQuestionnaireAnswer = $this->userQuestionnaireAnswerService->findOrCreate(
                        $answer,
                        $userQuestionnaire,
                        $content
                    );
                    $userQuestionnaire->addUserQuestionnaireAnswer($userQuestionnaireAnswer);
                }
            }
        }

        $userQuestionnaire->setIsCompleted(true);
        $this->userQuestionnaireManager->save($userQuestionnaire, (string) $userQuestionnaire->getUser());

        return $userQuestionnaire;
    }

    public function rewardUserQuestionnaire(UserQuestionnaire $userQuestionnaire): UserQuestionnaire
    {
        $user = $userQuestionnaire->getUser();
        $used = $this->promotionService->applySystemPromotion(
            'REWARD10',
            $user
        );

        if (true === $used) {
            $userQuestionnaire->setIsRewarded(true);
            $this->userQuestionnaireManager->save($userQuestionnaire, (string) $user);
        }

        return $userQuestionnaire;
    }
}
