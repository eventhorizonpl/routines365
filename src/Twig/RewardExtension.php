<?php

namespace App\Twig;

use App\Entity\Reward;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RewardExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('rewardType', [$this, 'rewardType']),
        ];
    }

    public function rewardType(): array
    {
        return Reward::getTypeFormChoices();
    }
}
