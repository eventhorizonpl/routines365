<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{Note, Routine, User};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
final class NoteTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $note = new Note();
        $note->setUuid($uuid);
        $this->assertSame($uuid, $note->__toString());
    }

    public function testGetId(): void
    {
        $note = new Note();
        $this->assertNull($note->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $note = new Note();
        $this->assertNull($note->getUuid());
        $note->setUuid($uuid);
        $this->assertSame($uuid, $note->getUuid());
        $this->assertIsString($note->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setUuid($uuid));
        $this->assertSame($uuid, $note->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $note = new Note();
        $this->assertNull($note->getCreatedBy());
        $note->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $note->getCreatedBy());
        $this->assertIsString($note->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $note->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $note = new Note();
        $this->assertNull($note->getDeletedBy());
        $note->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $note->getDeletedBy());
        $this->assertIsString($note->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $note->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $note = new Note();
        $this->assertNull($note->getUpdatedBy());
        $note->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $note->getUpdatedBy());
        $this->assertIsString($note->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $note->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertNull($note->getCreatedAt());
        $note->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $note->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $note->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertNull($note->getDeletedAt());
        $note->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $note->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $note->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertNull($note->getUpdatedAt());
        $note->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $note->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $note->getUpdatedAt());
    }

    public function testGetRoutine(): void
    {
        $routine = new Routine();
        $note = new Note();
        $note->setRoutine($routine);
        $this->assertSame($routine, $note->getRoutine());
    }

    public function testSetRoutine(): void
    {
        $routine = new Routine();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setRoutine($routine));
        $this->assertSame($routine, $note->getRoutine());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $note = new Note();
        $note->setUser($user);
        $this->assertSame($user, $note->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setUser($user));
        $this->assertSame($user, $note->getUser());
    }

    public function testGetContent(): void
    {
        $content = 'test content';
        $note = new Note();
        $this->assertSame('', $note->getContent());
        $note->setContent($content);
        $this->assertSame($content, $note->getContent());
        $this->assertIsString($note->getContent());
    }

    public function testSetContent(): void
    {
        $content = 'test content';
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setContent($content));
        $this->assertSame($content, $note->getContent());
    }

    public function testGetTitle(): void
    {
        $title = 'test title';
        $note = new Note();
        $this->assertSame('', $note->getTitle());
        $note->setTitle($title);
        $this->assertSame($title, $note->getTitle());
        $this->assertIsString($note->getTitle());
    }

    public function testSetTitle(): void
    {
        $title = 'test title';
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setTitle($title));
        $this->assertSame($title, $note->getTitle());
    }
}
