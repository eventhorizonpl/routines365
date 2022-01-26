<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\ReminderMessage;
use App\Enum\ReminderMessageTypeEnum;
use App\Factory\ReminderMessageFactory;
use DateTimeImmutable;
use Faker\{Factory, Generator};

class ReminderMessageFaker
{
    private Generator $faker;

    public function __construct(
        private ReminderMessageFactory $reminderMessageFactory
    ) {
        $this->faker = Factory::create();
    }

    public function createReminderMessage(
        ?string $content = null,
        ?ReminderMessageTypeEnum $type = null
    ): ReminderMessage {
        if (null === $content) {
            $content = (string) $this->faker->text();
        }

        if (null === $type) {
            $type = ReminderMessageTypeEnum::EMAIL;
        }

        $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
            $content,
            $type
        );
        $reminderMessage->setPostDate(new DateTimeImmutable());

        return $reminderMessage;
    }
}
