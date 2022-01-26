<?php

declare(strict_types=1);

namespace App\Enum;

enum ContactTypeEnum: string
{
    case FEATURE_IDEA = 'feature_idea';
    case QUESTION = 'question';
}
