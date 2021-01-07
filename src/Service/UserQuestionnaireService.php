<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Questionnaire;
use App\Entity\User;
use App\Entity\UserQuestionnaire;
use App\Factory\UserQuestionnaireFactory;
use App\Manager\UserQuestionnaireManager;
use App\Repository\UserQuestionnaireRepository;
use Symfony\Component\HttpFoundation\InputBag;

class UserQuestionnaireService
{
    private PromotionService $promotionService;
    private UserQuestionnaireAnswerService $userQuestionnaireAnswerService;
    private UserQuestionnaireFactory $userQuestionnaireFactory;
    private UserQuestionnaireManager $userQuestionnaireManager;
    private UserQuestionnaireRepository $userQuestionnaireRepository;

    public function __construct(
        PromotionService $promotionService,
        UserQuestionnaireAnswerService $userQuestionnaireAnswerService,
        UserQuestionnaireFactory $userQuestionnaireFactory,
        UserQuestionnaireManager $userQuestionnaireManager,
        UserQuestionnaireRepository $userQuestionnaireRepository
    ) {
        $this->promotionService = $promotionService;
        $this->userQuestionnaireAnswerService = $userQuestionnaireAnswerService;
        $this->userQuestionnaireFactory = $userQuestionnaireFactory;
        $this->userQuestionnaireManager = $userQuestionnaireManager;
        $this->userQuestionnaireRepository = $userQuestionnaireRepository;
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
        InputBag $inputBag,
        Questionnaire $questionnaire,
        UserQuestionnaire $userQuestionnaire
    ): UserQuestionnaire {
        foreach ($questionnaire->getQuestions() as $question) {
            $answerUuid = $inputBag->get($question->getUuid());
            foreach ($question->getAnswers() as $answer) {
                if ($answer->getUuid() === $answerUuid) {
                    $content = null;
                    if (Answer::TYPE_OWN === $answer->getType()) {
                        $content = $inputBag->get($question->getUuid().'_'.$answer->getUuid().'_'.Answer::TYPE_OWN);
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
        $used = $this->promotionService->applySystemPromotion(
            'REWARD10',
            $userQuestionnaire->getUser()
        );

        if (true === $used) {
            $userQuestionnaire->setIsRewarded(true);
            $this->userQuestionnaireManager->save($userQuestionnaire, (string) $userQuestionnaire->getUser());
        }

        return $userQuestionnaire;
    }
}