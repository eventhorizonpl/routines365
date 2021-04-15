<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\SavedEmail;
use App\Factory\SavedEmailFactory;
use App\Tests\AbstractTestCase;
use Faker\{Factory, Generator};

/**
 * @internal
 * @coversNothing
 */
final class SavedEmailFactoryTest extends AbstractTestCase
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
        $savedEmailFactory = new SavedEmailFactory();

        $this->assertInstanceOf(SavedEmailFactory::class, $savedEmailFactory);
    }

    public function testCreateSavedEmail(): void
    {
        $savedEmailFactory = new SavedEmailFactory();
        $savedEmail = $savedEmailFactory->createSavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail);
    }

    public function testCreateSavedEmailWithRequired(): void
    {
        $email = $this->faker->safeEmail();
        $type = $this->faker->randomElement(
            SavedEmail::getTypeFormChoices()
        );
        $savedEmailFactory = new SavedEmailFactory();
        $savedEmail = $savedEmailFactory->createSavedEmailWithRequired(
            $email,
            $type
        );
        $this->assertInstanceOf(SavedEmail::class, $savedEmail);
        $this->assertSame($email, $savedEmail->getEmail());
        $this->assertSame($type, $savedEmail->getType());
    }
}
