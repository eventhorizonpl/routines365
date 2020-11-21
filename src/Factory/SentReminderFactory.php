<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\SentReminder;
use Symfony\Component\Uid\Uuid;

class SentReminderFactory
{
    public function createSentReminder(): SentReminder
    {
        $sentReminder = new SentReminder();
        $sentReminder->setUuid((string) Uuid::v4());

        return $sentReminder;
    }
}
