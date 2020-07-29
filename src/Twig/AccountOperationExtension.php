<?php

namespace App\Twig;

use App\Entity\AccountOperation;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AccountOperationExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('accountOperationType', [$this, 'accountOperationType']),
        ];
    }

    public function accountOperationType(): array
    {
        return AccountOperation::getTypeFormChoices();
    }
}
