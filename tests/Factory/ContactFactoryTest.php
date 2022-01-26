<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Contact;
use App\Enum\{ContactStatusEnum, ContactTypeEnum};
use App\Factory\ContactFactory;
use App\Tests\AbstractTestCase;
use Faker\{Factory, Generator};

/**
 * @internal
 */
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
        $this->faker = null;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $contactFactory = new ContactFactory();

        $this->assertInstanceOf(ContactFactory::class, $contactFactory);
    }

    public function testCreateContact(): void
    {
        $contactFactory = new ContactFactory();
        $contact = $contactFactory->createContact();
        $this->assertInstanceOf(Contact::class, $contact);
    }

    public function testCreateContactWithRequired(): void
    {
        $content = $this->faker->sentence();
        $status = ContactStatusEnum::OPEN;
        $title = $this->faker->sentence();
        $type = ContactTypeEnum::QUESTION;
        $contactFactory = new ContactFactory();
        $contact = $contactFactory->createContactWithRequired(
            $content,
            $status,
            $title,
            $type
        );
        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertSame($content, $contact->getContent());
        $this->assertSame($status, $contact->getStatus());
        $this->assertSame($title, $contact->getTitle());
        $this->assertSame($type, $contact->getType());
    }
}
