<?php

namespace App\Twig;

use App\Entity\Quote;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class QuoteExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('quoteType', [$this, 'quoteType']),
        ];
    }

    public function quoteType(): array
    {
        return Quote::getTypeFormChoices();
    }
}
