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
    private AnswerFaker $answerFaker;
    private Generator $faker;
    private QuestionFaker $questionFaker;
    private QuestionnaireFactory $questionnaireFactory;
    private QuestionnaireManager $questionnaireManager;

    public function __construct(
        AnswerFaker $answerFaker,
        QuestionFaker $questionFaker,
        QuestionnaireFactory $questionnaireFactory,
        QuestionnaireManager $questionnaireManager
    ) {
        $this->answerFaker = $answerFaker;
        $this->faker = Factory::create();
        $this->questionFaker = $questionFaker;
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
