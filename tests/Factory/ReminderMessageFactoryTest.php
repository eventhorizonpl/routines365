<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\ReminderMessage;
use App\Factory\ReminderMessageFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

/**
 * @internal
 * @coversNothing
 */
final class ReminderMessageFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        $this->faker = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $reminderMessageFactory = new ReminderMessageFactory();

        $this->assertInstanceOf(ReminderMessageFactory::class, $reminderMessageFactory);
    }

    public function testCreateReminderMessage(): void
    {
        $reminderMessageFactory = new ReminderMessageFactory();
        $reminderMessage = $reminderMessageFactory->createReminderMessage();
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage);
    }

    public function testCreateReminderMessageWithRequired(): void
    {
        $content = $this->faker->sentence();
        $type = $this->faker->randomElement(
            ReminderMessage::getTypeFormChoices()
        );
        $reminderMessageFactory = new ReminderMessageFactory();
        $reminderMessage = $reminderMessageFactory->createReminderMessageWithRequired(
            $content,
            $type
        );
        $this->assertInstanceOf(ReminderMessage::class, $reminderMessage);
        $this->assertSame($content, $reminderMessage->getContent());
        $this->assertSame($type, $reminderMessage->getType());
    }
}
