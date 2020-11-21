<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Entity\Reminder;
use App\Factory\ReminderFactory;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

class ReminderFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $reminderFactory = new ReminderFactory();

        $this->assertInstanceOf(ReminderFactory::class, $reminderFactory);
    }

    public function testCreateReminder()
    {
        $reminderFactory = new ReminderFactory();
        $reminder = $reminderFactory->createReminder();
        $this->assertInstanceOf(Reminder::class, $reminder);
    }

    public function testCreateReminderWithRequired()
    {
        $hour = new DateTimeImmutable();
        $isEnabled = $this->faker->boolean;
        $minutesBefore = $this->faker->randomNumber;
        $sendEmail = $this->faker->boolean;
        $sendMotivationalMessage = $this->faker->boolean;
        $sendSms = $this->faker->boolean;
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
        $this->assertEquals($hour, $reminder->getHour());
        $this->assertEquals($isEnabled, $reminder->getIsEnabled());
        $this->assertEquals($minutesBefore, $reminder->getMinutesBefore());
        $this->assertEquals($sendEmail, $reminder->getSendEmail());
        $this->assertEquals($sendMotivationalMessage, $reminder->getSendMotivationalMessage());
        $this->assertEquals($sendSms, $reminder->getSendSms());
        $this->assertEquals($type, $reminder->getType());
    }
}
