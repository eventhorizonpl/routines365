<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Reminder;
use App\Factory\ReminderFactory;
use DateTimeImmutable;
use Faker\{Factory, Generator};

class ReminderFaker
{
    private Generator $faker;

    public function __construct(
        private ReminderFactory $reminderFactory
    ) {
        $this->faker = Factory::create();
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
            $hour = DateTimeImmutable::createFromMutable($this->faker->dateTime());
        }

        if (null === $isEnabled) {
            $isEnabled = (bool) $this->faker->boolean();
        }

        if (null === $minutesBefore) {
            $minutesBefore = (int) $this->faker->randomElement(
                Reminder::getMinutesBeforeValidationChoices()
            );
        }

        if (null === $sendEmail) {
            $sendEmail = (bool) $this->faker->boolean();
        }

        if (null === $sendMotivationalMessage) {
            $sendMotivationalMessage = (bool) $this->faker->boolean();
        }

        if ((null === $sendSms) && (false === $isEnabled)) {
            $sendSms = (bool) $this->faker->boolean();
        }
        $sendSms = false;

        if (null === $type) {
            $type = (string) $this->faker->randomElement(
                Reminder::getTypeValidationChoices()
            );
        }

        return $this->reminderFactory->createReminderWithRequired(
            $hour,
            $isEnabled,
            $minutesBefore,
            $sendEmail,
            $sendMotivationalMessage,
            $sendSms,
            $type
        );
    }
}
