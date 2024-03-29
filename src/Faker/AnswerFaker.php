<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Answer;
use App\Factory\AnswerFactory;
use App\Manager\AnswerManager;
use Faker\{Factory, Generator};

class AnswerFaker
{
    private Generator $faker;

    public function __construct(
        private AnswerFactory $answerFactory,
        private AnswerManager $answerManager
    ) {
        $this->faker = Factory::create();
    }

    public function createAnswer(
        ?string $content = null,
        ?bool $isEnabled = null,
        ?int $position = null,
        ?string $type = null
    ): Answer {
        if (null === $content) {
            $content = (string) $this->faker->word();
        }

        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean();
        }

        if (null === $position) {
            $position = (int) $this->faker->numberBetween(1, 10);
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Answer::getTypeFormChoices()
            );
        }

        return $this->answerFactory->createAnswerWithRequired(
            $content,
            $isEnabled,
            $position,
            $type
        );
    }
}
