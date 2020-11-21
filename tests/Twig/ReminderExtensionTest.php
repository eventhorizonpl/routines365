<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\Tests\AbstractTestCase;
use App\Twig\ReminderExtension;

class ReminderExtensionTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $reminderExtension = new ReminderExtension();

        $this->assertInstanceOf(ReminderExtension::class, $reminderExtension);
    }

    public function testGetFunctions()
    {
        $reminderExtension = new ReminderExtension();

        $this->assertCount(1, $reminderExtension->getFunctions());
        $this->assertIsArray($reminderExtension->getFunctions());
    }

    public function testReminderType()
    {
        $reminderExtension = new ReminderExtension();

        $this->assertCount(8, $reminderExtension->reminderType());
        $this->assertIsArray($reminderExtension->reminderType());
    }
}
