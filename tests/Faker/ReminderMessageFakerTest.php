<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\ReminderMessage;
use App\Factory\ReminderMessageFactory;
use App\Faker\ReminderMessageFaker;
use App\Tests\AbstractDoctrineTestCase;

final class ReminderMessageFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ReminderMessageFactory $reminderMessageFactory;
    /**
     * @inject
     */
    private ?ReminderMessageFaker $reminderMessageFaker;

    protected function tearDown(): void
    {
        unset($this->reminderMessageFactory);
        unset($this->reminderMessageFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $reminderMessageFaker = new ReminderMessageFaker($this->reminderMessageFactory);

        $this->assertInstanceOf(ReminderMessageFaker::class, $reminderMessageFaker);
    }

    public function testCreateReminderMessage()
    {
        $this->purge();
        $reminderMessage = $this->reminderMessageFaker->createReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage);
        $content = 'test content';
        $type = ReminderMessage::TYPE_EMAIL;
        $reminderMessage = $this->reminderMessageFaker->createReminderMessage(
            $content,
            $type
        );
        $this->assertEquals($content, $reminderMessage->getContent());
        $this->assertEquals($type, $reminderMessage->getType());
    }
}
