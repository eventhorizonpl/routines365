<?php

namespace App\Twig;

use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UserExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('userType', [$this, 'userType']),
        ];
    }

    public function userType(): array
    {
        return User::getTypeFormChoices();
    }
}
