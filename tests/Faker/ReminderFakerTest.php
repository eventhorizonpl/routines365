<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Reminder;
use App\Factory\ReminderFactory;
use App\Faker\ReminderFaker;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;

final class ReminderFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ReminderFactory $reminderFactory;
    /**
     * @inject
     */
    private ?ReminderFaker $reminderFaker;

    protected function tearDown(): void
    {
        unset(
            $this->reminderFactory,
            $this->reminderFaker
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $reminderFaker = new ReminderFaker($this->reminderFactory);

        $this->assertInstanceOf(ReminderFaker::class, $reminderFaker);
    }

    public function testCreateReminder(): void
    {
        $this->purge();
        $reminder = $this->reminderFaker->createReminder();
        $this->assertInstanceOf(Reminder::class, $reminder);
        $hour = new DateTimeImmutable();
        $isEnabled = true;
        $minutesBefore = 1;
        $sendEmail = true;
        $sendMotivationalMessage = true;
        $sendSms = false;
        $type = Reminder::TYPE_DAILY;
        $reminder = $this->reminderFaker->createReminder(
            $hour,
            $isEnabled,
            $minutesBefore,
            $sendEmail,
            $sendMotivationalMessage,
            $sendSms,
            $type
        );
        $this->assertEquals($hour, $reminder->getHour());
        $this->assertEquals($isEnabled, $reminder->getIsEnabled());
        $this->assertEquals($minutesBefore, $reminder->getMinutesBefore());
        $this->assertEquals($sendEmail, $reminder->getSendEmail());
        $this->assertEquals($sendMotivationalMessage, $reminder->getSendMotivationalMessage());
        $this->assertEquals($sendSms, $reminder->getSendSms());
        $this->assertEquals($type, $reminder->getType());

        $reminder = $this->reminderFaker->createReminder(
            null,
            false
        );
        $this->assertEquals(false, $reminder->getSendSms());
    }
}
