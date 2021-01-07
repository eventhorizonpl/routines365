<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Question;
use App\Factory\QuestionFactory;
use App\Manager\QuestionManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class QuestionFaker
{
    private Generator $faker;
    private QuestionFactory $questionFactory;
    private QuestionManager $questionManager;

    public function __construct(
        QuestionFactory $questionFactory,
        QuestionManager $questionManager
    ) {
        $this->faker = Factory::create();
        $this->questionFactory = $questionFactory;
        $this->questionManager = $questionManager;
    }

    public function createQuestion(
        ?bool $isEnabled = null,
        ?int $position = null,
        ?string $title = null,
        ?string $type = null
    ): Question {
        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean;
        }

        if (null === $position) {
            $position = (int) $this->faker->numberBetween(1, 10);
        }

        if (null === $title) {
            $title = (string) $this->faker->word;
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Question::getTypeFormChoices()
            );
        }

        $question = $this->questionFactory->createQuestionWithRequired(
            $isEnabled,
            $position,
            $title,
            $type
        );

        return $question;
    }

    public function createQuestionPersisted(
        ?bool $isEnabled = null,
        ?int $position = null,
        ?string $title = null,
        ?string $type = null
    ): Question {
        $question = $this->createQuestion(
            $isEnabled,
            $position,
            $title,
            $type
        );
        $this->questionManager->save($question, (string) Uuid::v4());

        return $question;
    }
}
