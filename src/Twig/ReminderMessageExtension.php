<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\ReminderMessage;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ReminderMessageExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('reminderMessageType', [$this, 'reminderMessageType']),
        ];
    }

    public function reminderMessageType(): array
    {
        return ReminderMessage::getTypeFormChoices();
    }
}
