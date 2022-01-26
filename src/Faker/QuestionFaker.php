<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Question;
use App\Enum\QuestionTypeEnum;
use App\Factory\QuestionFactory;
use App\Manager\QuestionManager;
use Faker\{Factory, Generator};

class QuestionFaker
{
    private Generator $faker;

    public function __construct(
        private QuestionFactory $questionFactory,
        private QuestionManager $questionManager
    ) {
        $this->faker = Factory::create();
    }

    public function createQuestion(
        ?bool $isEnabled = null,
        ?int $position = null,
        ?string $title = null,
        ?QuestionTypeEnum $type = null
    ): Question {
        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean();
        }

        if (null === $position) {
            $position = (int) $this->faker->numberBetween(1, 10);
        }

        if (null === $title) {
            $title = (string) $this->faker->word();
        }

        if (null === $type) {
            $type = QuestionTypeEnum::SINGLE_ANSWER;
        }

        return $this->questionFactory->createQuestionWithRequired(
            $isEnabled,
            $position,
            $title,
            $type
        );
    }
}
