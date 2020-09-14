<?php

namespace App\Factory;

use App\Entity\SentReminder;
use Symfony\Component\Uid\Uuid;

class SentReminderFactory
{
    public function createSentReminder(): SentReminder
    {
        $sentReminder = new SentReminder();
        $sentReminder->setUuid(Uuid::v4());

        return $sentReminder;
    }
}
