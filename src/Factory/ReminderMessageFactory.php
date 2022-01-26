<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\ReminderMessage;
use App\Enum\ReminderMessageTypeEnum;
use Symfony\Component\Uid\Uuid;

class ReminderMessageFactory
{
    public function createReminderMessage(): ReminderMessage
    {
        $reminderMessage = new ReminderMessage();
        $reminderMessage->setUuid((string) Uuid::v4());

        return $reminderMessage;
    }

    public function createReminderMessageWithRequired(
        string $content,
        ReminderMessageTypeEnum $type
    ): ReminderMessage {
        $reminderMessage = $this->createReminderMessage();

        $reminderMessage
            ->setContent($content)
            ->setType($type)
        ;

        return $reminderMessage;
    }
}
