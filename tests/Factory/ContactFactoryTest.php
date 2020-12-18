<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Contact;
use App\Factory\ContactFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

final class ContactFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $contactFactory = new ContactFactory();

        $this->assertInstanceOf(ContactFactory::class, $contactFactory);
    }

    public function testCreateContact()
    {
        $contactFactory = new ContactFactory();
        $contact = $contactFactory->createContact();
        $this->assertInstanceOf(Contact::class, $contact);
    }

    public function testCreateContactWithRequired()
    {
        $content = $this->faker->sentence;
        $status = $this->faker->randomElement(
            Contact::getStatusFormChoices()
        );
        $title = $this->faker->sentence;
        $type = $this->faker->randomElement(
            Contact::getTypeFormChoices()
        );
        $contactFactory = new ContactFactory();
        $contact = $contactFactory->createContactWithRequired(
            $content,
            $status,
            $title,
            $type
        );
        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertEquals($content, $contact->getContent());
        $this->assertEquals($status, $contact->getStatus());
        $this->assertEquals($title, $contact->getTitle());
        $this->assertEquals($type, $contact->getType());
    }
}
