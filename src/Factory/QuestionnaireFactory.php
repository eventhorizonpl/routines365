<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Questionnaire;
use Symfony\Component\Uid\Uuid;

class QuestionnaireFactory
{
    public function createQuestionnaire(): Questionnaire
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setUuid((string) Uuid::v4());

        return $questionnaire;
    }

    public function createQuestionnaireWithRequired(
        bool $isEnabled,
        string $title
    ): Questionnaire {
        $questionnaire = $this->createQuestionnaire();

        $questionnaire
            ->setIsEnabled($isEnabled)
            ->setTitle($title);

        return $questionnaire;
    }
}
