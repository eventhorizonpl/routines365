<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Promotion;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PromotionExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('promotionType', [$this, 'promotionType']),
        ];
    }

    public function promotionType(): array
    {
        return Promotion::getTypeFormChoices();
    }
}
