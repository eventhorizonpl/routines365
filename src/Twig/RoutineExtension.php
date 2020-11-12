<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Routine;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RoutineExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('routineType', [$this, 'routineType']),
        ];
    }

    public function routineType(): array
    {
        return Routine::getTypeFormChoices();
    }
}
