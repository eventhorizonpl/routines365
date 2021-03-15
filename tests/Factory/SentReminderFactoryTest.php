<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\SentReminder;
use App\Factory\SentReminderFactory;
use App\Tests\AbstractTestCase;

/**
 * @internal
 * @coversNothing
 */
final class SentReminderFactoryTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $sentReminderFactory = new SentReminderFactory();

        $this->assertInstanceOf(SentReminderFactory::class, $sentReminderFactory);
    }

    public function testCreateSentReminder(): void
    {
        $sentReminderFactory = new SentReminderFactory();
        $sentReminder = $sentReminderFactory->createSentReminder();
        $this->assertInstanceOf(SentReminder::class, $sentReminder);
    }
}
