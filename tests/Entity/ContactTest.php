<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Contact;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final class ContactTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $contact = new Contact();
        $contact->setUuid($uuid);
        $this->assertEquals($uuid, $contact->__toString());
    }

    public function testGetId(): void
    {
        $contact = new Contact();
        $this->assertEquals(null, $contact->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getUuid());
        $contact->setUuid($uuid);
        $this->assertEquals($uuid, $contact->getUuid());
        $this->assertIsString($contact->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUuid($uuid));
        $this->assertEquals($uuid, $contact->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getCreatedBy());
        $contact->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $contact->getCreatedBy());
        $this->assertIsString($contact->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $contact->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getDeletedBy());
        $contact->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $contact->getDeletedBy());
        $this->assertIsString($contact->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $contact->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getUpdatedBy());
        $contact->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $contact->getUpdatedBy());
        $this->assertIsString($contact->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $contact->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getCreatedAt());
        $contact->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $contact->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $contact->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getDeletedAt());
        $contact->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $contact->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $contact->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertEquals(null, $contact->getUpdatedAt());
        $contact->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $contact->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $contact->getUpdatedAt());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $contact = new Contact();
        $contact->setUser($user);
        $this->assertEquals($user, $contact->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUser($user));
        $this->assertEquals($user, $contact->getUser());
    }

    public function testGetComment(): void
    {
        $comment = 'test comment';
        $contact = new Contact();
        $this->assertEquals(null, $contact->getComment());
        $contact->setComment($comment);
        $this->assertEquals($comment, $contact->getComment());
        $this->assertIsString($contact->getComment());
    }

    public function testSetComment(): void
    {
        $comment = 'test comment';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setComment($comment));
        $this->assertEquals($comment, $contact->getComment());
    }

    public function testGetContent(): void
    {
        $content = 'test content';
        $contact = new Contact();
        $this->assertEquals(null, $contact->getContent());
        $contact->setContent($content);
        $this->assertEquals($content, $contact->getContent());
        $this->assertIsString($contact->getContent());
    }

    public function testSetContent(): void
    {
        $content = 'test content';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setContent($content));
        $this->assertEquals($content, $contact->getContent());
    }

    public function testGetStatus(): void
    {
        $status = Contact::STATUS_CLOSED;
        $contact = new Contact();
        $contact->setStatus($status);
        $this->assertEquals($status, $contact->getStatus());
        $this->assertIsString($contact->getStatus());
    }

    public function testGetStatusFormChoices(): void
    {
        $this->assertCount(6, Contact::getStatusFormChoices());
        $this->assertIsArray(Contact::getStatusFormChoices());
    }

    public function testGetStatusValidationChoices(): void
    {
        $this->assertCount(6, Contact::getStatusValidationChoices());
        $this->assertIsArray(Contact::getStatusValidationChoices());
    }

    public function testSetStatus(): void
    {
        $status = Contact::STATUS_CLOSED;
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setStatus($status));
        $this->assertEquals($status, $contact->getStatus());
    }

    public function testSetStatusException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $status = 'wrong status';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setStatus($status));
    }

    public function testGetTitle(): void
    {
        $title = 'test title';
        $contact = new Contact();
        $this->assertEquals(null, $contact->getTitle());
        $contact->setTitle($title);
        $this->assertEquals($title, $contact->getTitle());
        $this->assertIsString($contact->getTitle());
    }

    public function testSetTitle(): void
    {
        $title = 'test title';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setTitle($title));
        $this->assertEquals($title, $contact->getTitle());
    }

    public function testGetType(): void
    {
        $type = Contact::TYPE_FEATURE_IDEA;
        $contact = new Contact();
        $contact->setType($type);
        $this->assertEquals($type, $contact->getType());
        $this->assertIsString($contact->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(2, Contact::getTypeFormChoices());
        $this->assertIsArray(Contact::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(2, Contact::getTypeValidationChoices());
        $this->assertIsArray(Contact::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = Contact::TYPE_FEATURE_IDEA;
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setType($type));
        $this->assertEquals($type, $contact->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setType($type));
    }
}
