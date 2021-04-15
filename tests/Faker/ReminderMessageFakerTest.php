<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\ReminderMessage;
use App\Factory\ReminderMessageFactory;
use App\Faker\ReminderMessageFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
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
        $this->reminderMessageFactory = null;
        $this->reminderMessageFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $reminderMessageFaker = new ReminderMessageFaker($this->reminderMessageFactory);

        $this->assertInstanceOf(ReminderMessageFaker::class, $reminderMessageFaker);
    }

    public function testCreateReminderMessage(): void
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
        $this->assertSame($content, $reminderMessage->getContent());
        $this->assertSame($type, $reminderMessage->getType());
    }
}
