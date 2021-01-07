<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Questionnaire;
use App\Factory\QuestionnaireFactory;
use App\Manager\QuestionnaireManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class QuestionnaireFaker
{
    private Generator $faker;
    private QuestionnaireFactory $questionnaireFactory;
    private QuestionnaireManager $questionnaireManager;

    public function __construct(
        QuestionnaireFactory $questionnaireFactory,
        QuestionnaireManager $questionnaireManager
    ) {
        $this->faker = Factory::create();
        $this->questionnaireFactory = $questionnaireFactory;
        $this->questionnaireManager = $questionnaireManager;
    }

    public function createQuestionnaire(
        ?bool $isEnabled = null,
        ?string $title = null
    ): Questionnaire {
        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean;
        }

        if (null === $title) {
            $title = (string) $this->faker->word;
        }

        $questionnaire = $this->questionnaireFactory->createQuestionnaireWithRequired(
            $isEnabled,
            $title
        );

        return $questionnaire;
    }

    public function createQuestionnairePersisted(
        ?bool $isEnabled = null,
        ?string $title = null
    ): Questionnaire {
        $questionnaire = $this->createQuestionnaire(
            $isEnabled,
            $title
        );
        $this->questionnaireManager->save($questionnaire, (string) Uuid::v4());

        return $questionnaire;
    }
}
