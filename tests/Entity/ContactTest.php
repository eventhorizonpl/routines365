<?php

namespace App\Tests\Entity;

use App\Entity\Contact;
use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class ContactTest extends TestCase
{
    public function testConstruct()
    {
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact);
    }

    public function testToString()
    {
        $uuid = Uuid::v4();
        $contact = new Contact();
        $contact->setUuid($uuid);
        $this->assertEquals($uuid, $contact->__toString());
    }

    public function testGetId()
    {
        $contact = new Contact();
        $this->assertEquals(null, $contact->getId());
    }

    public function testGetUuid()
    {
        $uuid = Uuid::v4();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getUuid());
        $contact->setUuid($uuid);
        $this->assertEquals($uuid, $contact->getUuid());
        $this->assertIsString($contact->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUuid($uuid));
        $this->assertEquals($uuid, $contact->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = Uuid::v4();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getCreatedBy());
        $contact->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $contact->getCreatedBy());
        $this->assertIsString($contact->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $contact->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = Uuid::v4();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getDeletedBy());
        $contact->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $contact->getDeletedBy());
        $this->assertIsString($contact->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $contact->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = Uuid::v4();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getUpdatedBy());
        $contact->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $contact->getUpdatedBy());
        $this->assertIsString($contact->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $contact->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getCreatedAt());
        $contact->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $contact->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $contact->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getDeletedAt());
        $contact->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $contact->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $contact->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getUpdatedAt());
        $contact->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $contact->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $contact->getUpdatedAt());
    }

    public function testGetUser()
    {
        $user = new User();
        $contact = new Contact();
        $contact->setUser($user);
        $this->assertEquals($user, $contact->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUser($user));
        $this->assertEquals($user, $contact->getUser());
    }

    public function testGetComment()
    {
        $comment = 'test comment';
        $contact = new Contact();
        $this->assertEquals(null, $contact->getComment());
        $contact->setComment($comment);
        $this->assertEquals($comment, $contact->getComment());
        $this->assertIsString($contact->getComment());
    }

    public function testSetComment()
    {
        $comment = 'test comment';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setComment($comment));
        $this->assertEquals($comment, $contact->getComment());
    }

    public function testGetContent()
    {
        $content = 'test content';
        $contact = new Contact();
        $this->assertEquals(null, $contact->getContent());
        $contact->setContent($content);
        $this->assertEquals($content, $contact->getContent());
        $this->assertIsString($contact->getContent());
    }

    public function testSetContent()
    {
        $content = 'test content';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setContent($content));
        $this->assertEquals($content, $contact->getContent());
    }

    public function testGetStatus()
    {
        $status = Contact::STATUS_CLOSED;
        $contact = new Contact();
        $contact->setStatus($status);
        $this->assertEquals($status, $contact->getStatus());
        $this->assertIsString($contact->getStatus());
    }

    public function testGetStatusFormChoices()
    {
        $this->assertCount(6, Contact::getStatusFormChoices());
        $this->assertIsArray(Contact::getStatusFormChoices());
    }

    public function testGetStatusValidationChoices()
    {
        $this->assertCount(6, Contact::getStatusValidationChoices());
        $this->assertIsArray(Contact::getStatusValidationChoices());
    }

    public function testSetStatus()
    {
        $status = Contact::STATUS_CLOSED;
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setStatus($status));
        $this->assertEquals($status, $contact->getStatus());
    }

    public function testGetTitle()
    {
        $title = 'test title';
        $contact = new Contact();
        $this->assertEquals(null, $contact->getTitle());
        $contact->setTitle($title);
        $this->assertEquals($title, $contact->getTitle());
        $this->assertIsString($contact->getTitle());
    }

    public function testSetTitle()
    {
        $title = 'test title';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setTitle($title));
        $this->assertEquals($title, $contact->getTitle());
    }

    public function testGetType()
    {
        $type = Contact::TYPE_FEATURE_IDEA;
        $contact = new Contact();
        $contact->setType($type);
        $this->assertEquals($type, $contact->getType());
        $this->assertIsString($contact->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(2, Contact::getTypeFormChoices());
        $this->assertIsArray(Contact::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(2, Contact::getTypeValidationChoices());
        $this->assertIsArray(Contact::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = Contact::TYPE_FEATURE_IDEA;
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setType($type));
        $this->assertEquals($type, $contact->getType());
    }
}
