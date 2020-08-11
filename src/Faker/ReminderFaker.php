<?php

namespace App\Faker;

use App\Entity\Reminder;
use App\Factory\ReminderFactory;
use App\Manager\ReminderManager;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

class ReminderFaker
{
    private Generator $faker;
    private ReminderFactory $reminderFactory;
    private ReminderManager $reminderManager;

    public function __construct(
        ReminderFactory $reminderFactory,
        ReminderManager $reminderManager
    ) {
        $this->faker = Factory::create();
        $this->reminderFactory = $reminderFactory;
        $this->reminderManager = $reminderManager;
    }

    public function createReminder(
        ?DateTimeImmutable $hour = null,
        ?bool $isEnabled = null,
        ?int $minutesBefore = null,
        ?bool $sendEmail = null,
        ?bool $sendMotivationalMessage = null,
        ?bool $sendSms = null,
        ?string $type = null
    ): Reminder {
        if (null === $hour) {
            $hour = DateTimeImmutable::createFromMutable($this->faker->dateTime);
        }

        $isEnabled = (bool) $this->faker->boolean;

        if (null === $minutesBefore) {
            $minutesBefore = (int) $this->faker->randomElement(
                Reminder::getMinutesBeforeValidationChoices()
            );
        }

        if (null === $sendEmail) {
            $sendEmail = (bool) $this->faker->boolean;
        }

        if (null === $sendMotivationalMessage) {
            $sendMotivationalMessage = (bool) $this->faker->boolean;
        }

        $sendSms = false;
        if ((null === $sendSms) && (false === $isEnabled)) {
            $sendSms = (bool) $this->faker->boolean;
        }

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Reminder::getTypeValidationChoices()
            );
        }

        $reminder = $this->reminderFactory->createReminderWithRequired(
            $hour,
            $isEnabled,
            $minutesBefore,
            $sendEmail,
            $sendMotivationalMessage,
            $sendSms,
            $type
        );

        return $reminder;
    }

    public function createReminderPersisted(
        ?DateTimeImmutable $hour = null,
        ?bool $isEnabled = null,
        ?int $minutesBefore = null,
        ?bool $sendEmail = null,
        ?bool $sendMotivationalMessage = null,
        ?bool $sendSms = null,
        ?string $type = null
    ): Reminder {
        $reminder = $this->createReminder(
            $hour,
            $isEnabled,
            $minutesBefore,
            $sendEmail,
            $sendMotivationalMessage,
            $sendSms,
            $type
        );
        $this->reminderManager->save($reminder);

        return $reminder;
    }
}
