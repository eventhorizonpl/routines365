<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\ReminderMessage;
use App\Factory\ReminderMessageFactory;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

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
        ?string $type = null
    ): ReminderMessage {
        if (null === $content) {
            $content = (string) $this->faker->text;
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                ReminderMessage::getTypeValidationChoices()
            );
        }

        $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
            $content,
            $type
        );
        $reminderMessage->setPostDate(new DateTimeImmutable());

        return $reminderMessage;
    }
}
