<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Reminder;
use App\Factory\ReminderFactory;
use App\Faker\ReminderFaker;
use App\Tests\AbstractDoctrineTestCase;
use DateTimeImmutable;

/**
 * @internal
 * @coversNothing
 */
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
        $this->reminderFactory = null;
        $this->reminderFaker = null
        ;

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
        $this->assertSame($hour, $reminder->getHour());
        $this->assertSame($isEnabled, $reminder->getIsEnabled());
        $this->assertSame($minutesBefore, $reminder->getMinutesBefore());
        $this->assertSame($sendEmail, $reminder->getSendEmail());
        $this->assertSame($sendMotivationalMessage, $reminder->getSendMotivationalMessage());
        $this->assertSame($sendSms, $reminder->getSendSms());
        $this->assertSame($type, $reminder->getType());

        $reminder = $this->reminderFaker->createReminder(
            null,
            false
        );
        $this->assertFalse($reminder->getSendSms());
    }
}
