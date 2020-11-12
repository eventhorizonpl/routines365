<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Reminder;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ReminderExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('reminderType', [$this, 'reminderType']),
        ];
    }

    public function reminderType(): array
    {
        return Reminder::getTypeFormChoices();
    }
}
