<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\CompletedRoutine;
use App\Entity\Routine;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class CompletedRoutineTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setUuid($uuid);
        $this->assertEquals($uuid, $completedRoutine->__toString());
    }

    public function testGetId()
    {
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getUuid());
        $completedRoutine->setUuid($uuid);
        $this->assertEquals($uuid, $completedRoutine->getUuid());
        $this->assertIsString($completedRoutine->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUuid($uuid));
        $this->assertEquals($uuid, $completedRoutine->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getCreatedBy());
        $completedRoutine->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $completedRoutine->getCreatedBy());
        $this->assertIsString($completedRoutine->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $completedRoutine->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getDeletedBy());
        $completedRoutine->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $completedRoutine->getDeletedBy());
        $this->assertIsString($completedRoutine->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $completedRoutine->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getUpdatedBy());
        $completedRoutine->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $completedRoutine->getUpdatedBy());
        $this->assertIsString($completedRoutine->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $completedRoutine->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getCreatedAt());
        $completedRoutine->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $completedRoutine->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $completedRoutine->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getDeletedAt());
        $completedRoutine->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $completedRoutine->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $completedRoutine->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getUpdatedAt());
        $completedRoutine->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $completedRoutine->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $completedRoutine->getUpdatedAt());
    }

    public function testGetRoutine()
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setRoutine($routine);
        $this->assertEquals($routine, $completedRoutine->getRoutine());
    }

    public function testSetRoutine()
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setRoutine($routine));
        $this->assertEquals($routine, $completedRoutine->getRoutine());
    }

    public function testGetUser()
    {
        $user = new User();
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setUser($user);
        $this->assertEquals($user, $completedRoutine->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUser($user));
        $this->assertEquals($user, $completedRoutine->getUser());
    }

    public function testGetComment()
    {
        $comment = 'test comment';
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getComment());
        $completedRoutine->setComment($comment);
        $this->assertEquals($comment, $completedRoutine->getComment());
        $this->assertIsString($completedRoutine->getComment());
    }

    public function testSetComment()
    {
        $comment = 'test comment';
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setComment($comment));
        $this->assertEquals($comment, $completedRoutine->getComment());
    }

    public function testGetMinutesDevoted()
    {
        $minutesDevoted = 10;
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setMinutesDevoted($minutesDevoted);
        $this->assertEquals($minutesDevoted, $completedRoutine->getMinutesDevoted());
        $this->assertIsInt($completedRoutine->getMinutesDevoted());
    }

    public function testSetMinutesDevoted()
    {
        $minutesDevoted = 10;
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setMinutesDevoted($minutesDevoted));
        $this->assertEquals($minutesDevoted, $completedRoutine->getMinutesDevoted());
    }
}
