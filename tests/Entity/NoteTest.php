<?php

namespace App\Tests\Entity;

use App\Entity\Note;
use App\Entity\Routine;
use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class NoteTest extends TestCase
{
    public function testConstruct()
    {
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note);
    }

    public function testToString()
    {
        $uuid = Uuid::v4();
        $note = new Note();
        $note->setUuid($uuid);
        $this->assertEquals($uuid, $note->__toString());
    }

    public function testGetId()
    {
        $note = new Note();
        $this->assertEquals(null, $note->getId());
    }

    public function testGetUuid()
    {
        $uuid = Uuid::v4();
        $note = new Note();
        $this->assertEquals(null, $note->getUuid());
        $note->setUuid($uuid);
        $this->assertEquals($uuid, $note->getUuid());
        $this->assertIsString($note->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = Uuid::v4();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setUuid($uuid));
        $this->assertEquals($uuid, $note->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = Uuid::v4();
        $note = new Note();
        $this->assertEquals(null, $note->getCreatedBy());
        $note->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $note->getCreatedBy());
        $this->assertIsString($note->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = Uuid::v4();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $note->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = Uuid::v4();
        $note = new Note();
        $this->assertEquals(null, $note->getDeletedBy());
        $note->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $note->getDeletedBy());
        $this->assertIsString($note->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = Uuid::v4();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $note->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = Uuid::v4();
        $note = new Note();
        $this->assertEquals(null, $note->getUpdatedBy());
        $note->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $note->getUpdatedBy());
        $this->assertIsString($note->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = Uuid::v4();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $note->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertEquals(null, $note->getCreatedAt());
        $note->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $note->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $note->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertEquals(null, $note->getDeletedAt());
        $note->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $note->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $note->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertEquals(null, $note->getUpdatedAt());
        $note->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $note->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $note->getUpdatedAt());
    }

    public function testGetRoutine()
    {
        $routine = new Routine();
        $note = new Note();
        $note->setRoutine($routine);
        $this->assertEquals($routine, $note->getRoutine());
    }

    public function testSetRoutine()
    {
        $routine = new Routine();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setRoutine($routine));
        $this->assertEquals($routine, $note->getRoutine());
    }

    public function testGetUser()
    {
        $user = new User();
        $note = new Note();
        $note->setUser($user);
        $this->assertEquals($user, $note->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setUser($user));
        $this->assertEquals($user, $note->getUser());
    }

    public function testGetContent()
    {
        $content = 'test content';
        $note = new Note();
        $this->assertEquals(null, $note->getContent());
        $note->setContent($content);
        $this->assertEquals($content, $note->getContent());
        $this->assertIsString($note->getContent());
    }

    public function testSetContent()
    {
        $content = 'test content';
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setContent($content));
        $this->assertEquals($content, $note->getContent());
    }

    public function testGetTitle()
    {
        $title = 'test title';
        $note = new Note();
        $this->assertEquals(null, $note->getTitle());
        $note->setTitle($title);
        $this->assertEquals($title, $note->getTitle());
        $this->assertIsString($note->getTitle());
    }

    public function testSetTitle()
    {
        $title = 'test title';
        $note = new Note();
        $this->assertInstanceOf(Note::class, $note->setTitle($title));
        $this->assertEquals($title, $note->getTitle());
    }
}
