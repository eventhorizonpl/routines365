<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\CompletedRoutine;
use App\Entity\Routine;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class CompletedRoutineTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setUuid($uuid);
        $this->assertEquals($uuid, $completedRoutine->__toString());
    }

    public function testGetId(): void
    {
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getUuid());
        $completedRoutine->setUuid($uuid);
        $this->assertEquals($uuid, $completedRoutine->getUuid());
        $this->assertIsString($completedRoutine->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUuid($uuid));
        $this->assertEquals($uuid, $completedRoutine->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getCreatedBy());
        $completedRoutine->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $completedRoutine->getCreatedBy());
        $this->assertIsString($completedRoutine->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $completedRoutine->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getDeletedBy());
        $completedRoutine->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $completedRoutine->getDeletedBy());
        $this->assertIsString($completedRoutine->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $completedRoutine->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getUpdatedBy());
        $completedRoutine->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $completedRoutine->getUpdatedBy());
        $this->assertIsString($completedRoutine->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $completedRoutine->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getCreatedAt());
        $completedRoutine->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $completedRoutine->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $completedRoutine->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getDeletedAt());
        $completedRoutine->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $completedRoutine->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $completedRoutine->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getUpdatedAt());
        $completedRoutine->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $completedRoutine->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $completedRoutine->getUpdatedAt());
    }

    public function testGetRoutine(): void
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setRoutine($routine);
        $this->assertEquals($routine, $completedRoutine->getRoutine());
    }

    public function testSetRoutine(): void
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setRoutine($routine));
        $this->assertEquals($routine, $completedRoutine->getRoutine());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setUser($user);
        $this->assertEquals($user, $completedRoutine->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUser($user));
        $this->assertEquals($user, $completedRoutine->getUser());
    }

    public function testGetComment(): void
    {
        $comment = 'test comment';
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getComment());
        $completedRoutine->setComment($comment);
        $this->assertEquals($comment, $completedRoutine->getComment());
        $this->assertIsString($completedRoutine->getComment());
    }

    public function testSetComment(): void
    {
        $comment = 'test comment';
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setComment($comment));
        $this->assertEquals($comment, $completedRoutine->getComment());
    }

    public function testGetDate(): void
    {
        $date = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertEquals(null, $completedRoutine->getDate());
        $completedRoutine->setDate($date);
        $this->assertEquals($date, $completedRoutine->getDate());
    }

    public function testSetDate(): void
    {
        $date = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setDate($date));
        $this->assertEquals($date, $completedRoutine->getDate());
    }

    public function testGetMinutesDevoted(): void
    {
        $minutesDevoted = 10;
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setMinutesDevoted($minutesDevoted);
        $this->assertEquals($minutesDevoted, $completedRoutine->getMinutesDevoted());
        $this->assertIsInt($completedRoutine->getMinutesDevoted());
    }

    public function testSetMinutesDevoted(): void
    {
        $minutesDevoted = 10;
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setMinutesDevoted($minutesDevoted));
        $this->assertEquals($minutesDevoted, $completedRoutine->getMinutesDevoted());
    }
}
