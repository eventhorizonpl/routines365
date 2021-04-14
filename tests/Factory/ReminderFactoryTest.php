<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Reminder;
use App\Factory\ReminderFactory;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

/**
 * @internal
 * @coversNothing
 */
final class ReminderFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        $this->faker = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $reminderFactory = new ReminderFactory();

        $this->assertInstanceOf(ReminderFactory::class, $reminderFactory);
    }

    public function testCreateReminder(): void
    {
        $reminderFactory = new ReminderFactory();
        $reminder = $reminderFactory->createReminder();
        $this->assertInstanceOf(Reminder::class, $reminder);
    }

    public function testCreateReminderWithRequired(): void
    {
        $hour = new DateTimeImmutable();
        $isEnabled = $this->faker->boolean();
        $minutesBefore = $this->faker->randomNumber();
        $sendEmail = $this->faker->boolean();
        $sendMotivationalMessage = $this->faker->boolean();
        $sendSms = $this->faker->boolean();
        $type = $this->faker->randomElement(
            Reminder::getTypeFormChoices()
        );
        $reminderFactory = new ReminderFactory();
        $reminder = $reminderFactory->createReminderWithRequired(
            $hour,
            $isEnabled,
            $minutesBefore,
            $sendEmail,
            $sendMotivationalMessage,
            $sendSms,
            $type
        );
        $this->assertInstanceOf(Reminder::class, $reminder);
        $this->assertSame($hour, $reminder->getHour());
        $this->assertSame($isEnabled, $reminder->getIsEnabled());
        $this->assertSame($minutesBefore, $reminder->getMinutesBefore());
        $this->assertSame($sendEmail, $reminder->getSendEmail());
        $this->assertSame($sendMotivationalMessage, $reminder->getSendMotivationalMessage());
        $this->assertSame($type, $reminder->getType());
        $this->assertSame($sendSms, $reminder->getSendSms());
    }
}
