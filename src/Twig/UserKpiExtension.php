<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\UserKpi;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UserKpiExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('userKpiType', [$this, 'userKpiType']),
        ];
    }

    public function userKpiType(): array
    {
        return UserKpi::getTypeFormChoices();
    }
}
