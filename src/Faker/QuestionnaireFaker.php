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

    public function __construct(
        private AnswerFaker $answerFaker,
        private QuestionFaker $questionFaker,
        private QuestionnaireFactory $questionnaireFactory,
        private QuestionnaireManager $questionnaireManager
    ) {
        $this->faker = Factory::create();
    }

    public function createQuestionnaire(
        ?bool $isEnabled = null,
        ?string $title = null
    ): Questionnaire {
        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean();
        }

        if (null === $title) {
            $title = (string) $this->faker->word();
        }

        return $this->questionnaireFactory->createQuestionnaireWithRequired(
            $isEnabled,
            $title
        );
    }

    public function createRichQuestionnairePersisted(): Questionnaire
    {
        $questionnaire = $this->createQuestionnaire(true);

        $question = $this->questionFaker->createQuestion(true);
        $questionnaire->addQuestion($question);

        $answer = $this->answerFaker->createAnswer(
            null,
            true
        );
        $question->addAnswer($answer);

        $this->questionnaireManager->save($questionnaire, (string) Uuid::v4(), true, true);

        return $questionnaire;
    }
}
