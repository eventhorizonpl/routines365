<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Question;
use Symfony\Component\Uid\Uuid;

class QuestionFactory
{
    public function createQuestion(): Question
    {
        $question = new Question();
        $question->setUuid((string) Uuid::v4());

        return $question;
    }

    public function createQuestionWithRequired(
        bool $isEnabled,
        int $position,
        string $title,
        string $type
    ): Question {
        $question = $this->createQuestion();

        $question
            ->setIsEnabled($isEnabled)
            ->setPosition($position)
            ->setTitle($title)
            ->setType($type);

        return $question;
    }
}
