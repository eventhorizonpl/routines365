<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\ReminderExtension;

final class ReminderExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $reminderExtension = new ReminderExtension();

        $this->assertInstanceOf(ReminderExtension::class, $reminderExtension);
    }

    public function testGetFunctions(): void
    {
        $reminderExtension = new ReminderExtension();

        $this->assertCount(1, $reminderExtension->getFunctions());
        $this->assertIsArray($reminderExtension->getFunctions());
    }

    public function testReminderType(): void
    {
        $reminderExtension = new ReminderExtension();

        $this->assertCount(8, $reminderExtension->reminderType());
        $this->assertIsArray($reminderExtension->reminderType());
    }
}
