<?php

declare(strict_types=1);

namespace App\Enum;

enum ReportStatusEnum: string
{
    case FINISHED = 'finished';
    case INITIAL = 'initial';
    case IN_PROGRESS = 'in_progress';
}
