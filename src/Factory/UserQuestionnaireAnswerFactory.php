<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\UserQuestionnaireAnswer;
use Symfony\Component\Uid\Uuid;

class UserQuestionnaireAnswerFactory
{
    public function createUserQuestionnaireAnswer(): UserQuestionnaireAnswer
    {
        $userQuestionnaireAnswer = new UserQuestionnaireAnswer();
        $userQuestionnaireAnswer->setUuid((string) Uuid::v4());

        return $userQuestionnaireAnswer;
    }
}
