<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Report;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ReportExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('reportStatus', [$this, 'reportStatus']),
            new TwigFunction('reportType', [$this, 'reportType']),
        ];
    }

    public function reportStatus(): array
    {
        return Report::getStatusFormChoices();
    }

    public function reportType(): array
    {
        return Report::getTypeFormChoices();
    }
}
