<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{Contact, User};
use App\Enum\{ContactStatusEnum, ContactTypeEnum};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
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
        $this->assertSame($uuid, $contact->__toString());
    }

    public function testGetId(): void
    {
        $contact = new Contact();
        $this->assertNull($contact->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertNull($contact->getUuid());
        $contact->setUuid($uuid);
        $this->assertSame($uuid, $contact->getUuid());
        $this->assertIsString($contact->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUuid($uuid));
        $this->assertSame($uuid, $contact->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertNull($contact->getCreatedBy());
        $contact->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $contact->getCreatedBy());
        $this->assertIsString($contact->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $contact->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertNull($contact->getDeletedBy());
        $contact->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $contact->getDeletedBy());
        $this->assertIsString($contact->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $contact->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertNull($contact->getUpdatedBy());
        $contact->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $contact->getUpdatedBy());
        $this->assertIsString($contact->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $contact->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertNull($contact->getCreatedAt());
        $contact->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $contact->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $contact->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertNull($contact->getDeletedAt());
        $contact->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $contact->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $contact->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertNull($contact->getUpdatedAt());
        $contact->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $contact->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $contact->getUpdatedAt());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $contact = new Contact();
        $contact->setUser($user);
        $this->assertSame($user, $contact->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setUser($user));
        $this->assertSame($user, $contact->getUser());
    }

    public function testGetComment(): void
    {
        $comment = 'test comment';
        $contact = new Contact();
        $this->assertSame('', $contact->getComment());
        $contact->setComment($comment);
        $this->assertSame($comment, $contact->getComment());
        $this->assertIsString($contact->getComment());
    }

    public function testSetComment(): void
    {
        $comment = 'test comment';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setComment($comment));
        $this->assertSame($comment, $contact->getComment());
    }

    public function testGetContent(): void
    {
        $content = 'test content';
        $contact = new Contact();
        $this->assertSame('', $contact->getContent());
        $contact->setContent($content);
        $this->assertSame($content, $contact->getContent());
        $this->assertIsString($contact->getContent());
    }

    public function testSetContent(): void
    {
        $content = 'test content';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setContent($content));
        $this->assertSame($content, $contact->getContent());
    }

    public function testGetStatus(): void
    {
        $status = ContactStatusEnum::CLOSED;
        $contact = new Contact();
        $contact->setStatus($status);
        $this->assertSame($status, $contact->getStatus());
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
        $status = ContactStatusEnum::CLOSED;
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setStatus($status));
        $this->assertSame($status, $contact->getStatus());
    }

    public function testGetTitle(): void
    {
        $title = 'test title';
        $contact = new Contact();
        $this->assertSame('', $contact->getTitle());
        $contact->setTitle($title);
        $this->assertSame($title, $contact->getTitle());
        $this->assertIsString($contact->getTitle());
    }

    public function testSetTitle(): void
    {
        $title = 'test title';
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setTitle($title));
        $this->assertSame($title, $contact->getTitle());
    }

    public function testGetType(): void
    {
        $type = ContactTypeEnum::FEATURE_IDEA;
        $contact = new Contact();
        $contact->setType($type);
        $this->assertSame($type, $contact->getType());
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
        $type = ContactTypeEnum::FEATURE_IDEA;
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact->setType($type));
        $this->assertSame($type, $contact->getType());
    }
}
