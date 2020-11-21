<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\ReminderMessage;
use App\Factory\ReminderMessageFactory;
use App\Manager\ReminderMessageManager;
use Faker\Factory;
use Faker\Generator;

class ReminderMessageFaker
{
    private Generator $faker;
    private ReminderMessageFactory $reminderMessageFactory;
    private ReminderMessageManager $reminderMessageManager;

    public function __construct(
        ReminderMessageFactory $reminderMessageFactory,
        ReminderMessageManager $reminderMessageManager
    ) {
        $this->faker = Factory::create();
        $this->reminderMessageFactory = $reminderMessageFactory;
        $this->reminderMessageManager = $reminderMessageManager;
    }

    public function createReminderMessage(
        ?string $content = null,
        ?string $type = null
    ): ReminderMessage {
        $content = (string) $this->faker->text;

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                ReminderMessage::getTypeValidationChoices()
            );
        }

        $reminderMessage = $this->reminderMessageFactory->createReminderMessageWithRequired(
            $content,
            $type
        );

        return $reminderMessage;
    }
}
