<?php

declare(strict_types=1);

namespace App\Enum;

enum QuestionTypeEnum: string
{
    case MULTIPLE_ANSWER = 'multiple_answer';
    case SINGLE_ANSWER = 'single_answer';
}
