<?php

namespace App\Factory;

use App\Entity\Reminder;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class ReminderFactory
{
    public function createReminder(): Reminder
    {
        $reminder = new Reminder();
        $reminder->setUuid(Uuid::v4());

        return $reminder;
    }

    public function createReminderWithRequired(
        DateTimeImmutable $hour,
        bool $isEnabled,
        int $minutesBefore,
        bool $sendEmail,
        bool $sendSms,
        string $type
    ): Reminder {
        $reminder = $this->createReminder();

        $reminder
            ->setHour($hour)
            ->setIsEnabled($isEnabled)
            ->setMinutesBefore($minutesBefore)
            ->setSendEmail($sendEmail)
            ->setSendSms($sendSms)
            ->setType($type);

        return $reminder;
    }
}
