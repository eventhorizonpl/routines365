<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Reminder;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class ReminderFactory
{
    public function createReminder(): Reminder
    {
        $reminder = new Reminder();
        $reminder->setUuid((string) Uuid::v4());

        return $reminder;
    }

    public function createReminderWithRequired(
        DateTimeImmutable $hour,
        bool $isEnabled,
        int $minutesBefore,
        bool $sendEmail,
        bool $sendMotivationalMessage,
        bool $sendSms,
        string $type
    ): Reminder {
        $reminder = $this->createReminder();

        $reminder
            ->setHour($hour)
            ->setIsEnabled($isEnabled)
            ->setMinutesBefore($minutesBefore)
            ->setSendEmail($sendEmail)
            ->setSendMotivationalMessage($sendMotivationalMessage)
            ->setSendSms($sendSms)
            ->setType($type);

        return $reminder;
    }
}
