<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\ReminderMessageExtension;

class ReminderMessageExtensionTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $reminderMessageExtension = new ReminderMessageExtension();

        $this->assertInstanceOf(ReminderMessageExtension::class, $reminderMessageExtension);
    }

    public function testGetFunctions()
    {
        $reminderMessageExtension = new ReminderMessageExtension();

        $this->assertCount(1, $reminderMessageExtension->getFunctions());
        $this->assertIsArray($reminderMessageExtension->getFunctions());
    }

    public function testReminderMessageType()
    {
        $reminderMessageExtension = new ReminderMessageExtension();

        $this->assertCount(2, $reminderMessageExtension->reminderMessageType());
        $this->assertIsArray($reminderMessageExtension->reminderMessageType());
    }
}
