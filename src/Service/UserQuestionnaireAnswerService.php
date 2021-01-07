<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Answer;
use App\Entity\UserQuestionnaire;
use App\Entity\UserQuestionnaireAnswer;
use App\Factory\UserQuestionnaireAnswerFactory;
use App\Manager\UserQuestionnaireAnswerManager;
use App\Repository\UserQuestionnaireAnswerRepository;

class UserQuestionnaireAnswerService
{
    private UserQuestionnaireAnswerFactory $userQuestionnaireAnswerFactory;
    private UserQuestionnaireAnswerManager $userQuestionnaireAnswerManager;
    private UserQuestionnaireAnswerRepository $userQuestionnaireAnswerRepository;

    public function __construct(
        UserQuestionnaireAnswerFactory $userQuestionnaireAnswerFactory,
        UserQuestionnaireAnswerManager $userQuestionnaireAnswerManager,
        UserQuestionnaireAnswerRepository $userQuestionnaireAnswerRepository
    ) {
        $this->userQuestionnaireAnswerFactory = $userQuestionnaireAnswerFactory;
        $this->userQuestionnaireAnswerManager = $userQuestionnaireAnswerManager;
        $this->userQuestionnaireAnswerRepository = $userQuestionnaireAnswerRepository;
    }

    public function findOrCreate(
        Answer $answer,
        UserQuestionnaire $userQuestionnaire,
        ?string $content = null
    ): ?UserQuestionnaireAnswer {
        $userQuestionnaireAnswer = $this->userQuestionnaireAnswerRepository->findOneBy([
            'answer' => $answer,
            'userQuestionnaire' => $userQuestionnaire,
        ]);

        if (null === $userQuestionnaireAnswer) {
            $userQuestionnaireAnswer = $this->userQuestionnaireAnswerFactory->createUserQuestionnaireAnswer();
            $userQuestionnaireAnswer->setAnswer($answer);
            $userQuestionnaireAnswer->setUserQuestionnaire($userQuestionnaire);
            if (null !== $content) {
                $userQuestionnaireAnswer->setContent($content);
            }
            $this->userQuestionnaireAnswerManager->save($userQuestionnaireAnswer, (string) $userQuestionnaire->getUser());
        }

        return $userQuestionnaireAnswer;
    }
}
