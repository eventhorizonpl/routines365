<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Contact;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ContactExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('contactStatus', [$this, 'contactStatus']),
            new TwigFunction('contactType', [$this, 'contactType']),
        ];
    }

    public function contactStatus(): array
    {
        return Contact::getStatusFormChoices();
    }

    public function contactType(): array
    {
        return Contact::getTypeFormChoices();
    }
}
