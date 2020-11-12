<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\SavedEmail;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SavedEmailExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('savedEmailType', [$this, 'savedEmailType']),
        ];
    }

    public function savedEmailType(): array
    {
        return SavedEmail::getTypeFormChoices();
    }
}
