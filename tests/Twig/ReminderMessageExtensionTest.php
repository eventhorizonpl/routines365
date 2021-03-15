<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\ReminderMessageExtension;

/**
 * @internal
 * @coversNothing
 */
final class ReminderMessageExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $reminderMessageExtension = new ReminderMessageExtension();

        $this->assertInstanceOf(ReminderMessageExtension::class, $reminderMessageExtension);
    }

    public function testGetFunctions(): void
    {
        $reminderMessageExtension = new ReminderMessageExtension();

        $this->assertCount(1, $reminderMessageExtension->getFunctions());
        $this->assertIsArray($reminderMessageExtension->getFunctions());
    }

    public function testReminderMessageType(): void
    {
        $reminderMessageExtension = new ReminderMessageExtension();

        $this->assertCount(3, $reminderMessageExtension->reminderMessageType());
        $this->assertIsArray($reminderMessageExtension->reminderMessageType());
    }
}
