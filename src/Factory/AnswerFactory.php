<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Answer;
use Symfony\Component\Uid\Uuid;

class AnswerFactory
{
    public function createAnswer(): Answer
    {
        $answer = new Answer();
        $answer->setUuid((string) Uuid::v4());

        return $answer;
    }

    public function createAnswerWithRequired(
        string $content,
        bool $isEnabled,
        int $position,
        string $type
    ): Answer {
        $answer = $this->createAnswer();

        $answer
            ->setContent($content)
            ->setIsEnabled($isEnabled)
            ->setPosition($position)
            ->setType($type)
        ;

        return $answer;
    }
}
