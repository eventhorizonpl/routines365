<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Achievement;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AchievementExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('achievementType', [$this, 'achievementType']),
        ];
    }

    public function achievementType(): array
    {
        return Achievement::getTypeFormChoices();
    }
}
