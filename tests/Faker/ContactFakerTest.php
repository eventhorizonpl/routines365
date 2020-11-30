<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Contact;
use App\Factory\ContactFactory;
use App\Faker\ContactFaker;
use App\Tests\AbstractDoctrineTestCase;

class ContactFakerTest extends AbstractDoctrineTestCase
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
        unset($this->contactFactory);
        unset($this->contactFaker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $contactFaker = new ContactFaker($this->contactFactory);

        $this->assertInstanceOf(ContactFaker::class, $contactFaker);
    }

    public function testCreateContact()
    {
        $this->purge();
        $contact = $this->contactFaker->createContact();
        $this->assertInstanceOf(Contact::class, $contact);
        $content = 'test content';
        $status = 'test status';
        $title = 'test title';
        $type = 'test type';
        $contact = $this->contactFaker->createContact(
            $content,
            $status,
            $title,
            $type
        );
        $this->assertEquals($content, $contact->getContent());
        $this->assertEquals($status, $contact->getStatus());
        $this->assertEquals($title, $contact->getTitle());
        $this->assertEquals($type, $contact->getType());
    }
}
