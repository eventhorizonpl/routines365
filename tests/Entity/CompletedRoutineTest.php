<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{CompletedRoutine, Routine, User};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
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
        $this->assertSame($uuid, $completedRoutine->__toString());
    }

    public function testGetId(): void
    {
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getUuid());
        $completedRoutine->setUuid($uuid);
        $this->assertSame($uuid, $completedRoutine->getUuid());
        $this->assertIsString($completedRoutine->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUuid($uuid));
        $this->assertSame($uuid, $completedRoutine->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getCreatedBy());
        $completedRoutine->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $completedRoutine->getCreatedBy());
        $this->assertIsString($completedRoutine->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $completedRoutine->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getDeletedBy());
        $completedRoutine->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $completedRoutine->getDeletedBy());
        $this->assertIsString($completedRoutine->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $completedRoutine->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getUpdatedBy());
        $completedRoutine->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $completedRoutine->getUpdatedBy());
        $this->assertIsString($completedRoutine->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $completedRoutine->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getCreatedAt());
        $completedRoutine->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $completedRoutine->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $completedRoutine->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getDeletedAt());
        $completedRoutine->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $completedRoutine->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $completedRoutine->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getUpdatedAt());
        $completedRoutine->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $completedRoutine->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $completedRoutine->getUpdatedAt());
    }

    public function testGetRoutine(): void
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setRoutine($routine);
        $this->assertSame($routine, $completedRoutine->getRoutine());
    }

    public function testSetRoutine(): void
    {
        $routine = new Routine();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setRoutine($routine));
        $this->assertSame($routine, $completedRoutine->getRoutine());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setUser($user);
        $this->assertSame($user, $completedRoutine->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setUser($user));
        $this->assertSame($user, $completedRoutine->getUser());
    }

    public function testGetComment(): void
    {
        $comment = 'test comment';
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getComment());
        $completedRoutine->setComment($comment);
        $this->assertSame($comment, $completedRoutine->getComment());
        $this->assertIsString($completedRoutine->getComment());
    }

    public function testSetComment(): void
    {
        $comment = 'test comment';
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setComment($comment));
        $this->assertSame($comment, $completedRoutine->getComment());
    }

    public function testGetDate(): void
    {
        $date = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertNull($completedRoutine->getDate());
        $completedRoutine->setDate($date);
        $this->assertSame($date, $completedRoutine->getDate());
    }

    public function testSetDate(): void
    {
        $date = new DateTimeImmutable();
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setDate($date));
        $this->assertSame($date, $completedRoutine->getDate());
    }

    public function testGetMinutesDevoted(): void
    {
        $minutesDevoted = 10;
        $completedRoutine = new CompletedRoutine();
        $completedRoutine->setMinutesDevoted($minutesDevoted);
        $this->assertSame($minutesDevoted, $completedRoutine->getMinutesDevoted());
        $this->assertIsInt($completedRoutine->getMinutesDevoted());
    }

    public function testSetMinutesDevoted(): void
    {
        $minutesDevoted = 10;
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(CompletedRoutine::class, $completedRoutine->setMinutesDevoted($minutesDevoted));
        $this->assertSame($minutesDevoted, $completedRoutine->getMinutesDevoted());
    }
}
