<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Contact;
use App\Factory\ContactFactory;
use App\Faker\ContactFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class ContactFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?ContactFactory $contactFactory;
    /**
     * @inject
     */
    private ?ContactFaker $contactFaker;

    protected function tearDown(): void
    {
        $this->contactFactory = null;
        $this->contactFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $contactFaker = new ContactFaker($this->contactFactory);

        $this->assertInstanceOf(ContactFaker::class, $contactFaker);
    }

    public function testCreateContact(): void
    {
        $this->purge();
        $contact = $this->contactFaker->createContact();
        $this->assertInstanceOf(Contact::class, $contact);
        $content = 'test content';
        $status = Contact::STATUS_SPAM;
        $title = 'test title';
        $type = Contact::TYPE_FEATURE_IDEA;
        $contact = $this->contactFaker->createContact(
            $content,
            $status,
            $title,
            $type
        );
        $this->assertSame($content, $contact->getContent());
        $this->assertSame($status, $contact->getStatus());
        $this->assertSame($title, $contact->getTitle());
        $this->assertSame($type, $contact->getType());
    }
}
