<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{SavedEmail, User};
use App\Enum\SavedEmailTypeEnum;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
final class SavedEmailTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $savedEmail->setUuid($uuid);
        $this->assertSame($uuid, $savedEmail->__toString());
    }

    public function testGetId(): void
    {
        $savedEmail = new SavedEmail();
        $this->assertNull($savedEmail->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertNull($savedEmail->getUuid());
        $savedEmail->setUuid($uuid);
        $this->assertSame($uuid, $savedEmail->getUuid());
        $this->assertIsString($savedEmail->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUuid($uuid));
        $this->assertSame($uuid, $savedEmail->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertNull($savedEmail->getCreatedBy());
        $savedEmail->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $savedEmail->getCreatedBy());
        $this->assertIsString($savedEmail->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $savedEmail->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertNull($savedEmail->getDeletedBy());
        $savedEmail->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $savedEmail->getDeletedBy());
        $this->assertIsString($savedEmail->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $savedEmail->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertNull($savedEmail->getUpdatedBy());
        $savedEmail->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $savedEmail->getUpdatedBy());
        $this->assertIsString($savedEmail->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $savedEmail->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertNull($savedEmail->getCreatedAt());
        $savedEmail->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $savedEmail->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $savedEmail->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertNull($savedEmail->getDeletedAt());
        $savedEmail->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $savedEmail->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $savedEmail->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertNull($savedEmail->getUpdatedAt());
        $savedEmail->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $savedEmail->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $savedEmail->getUpdatedAt());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $savedEmail = new SavedEmail();
        $savedEmail->setUser($user);
        $this->assertSame($user, $savedEmail->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUser($user));
        $this->assertSame($user, $savedEmail->getUser());
    }

    public function testGetEmail(): void
    {
        $email = 'test email';
        $savedEmail = new SavedEmail();
        $this->assertSame('', $savedEmail->getEmail());
        $savedEmail->setEmail($email);
        $this->assertSame($email, $savedEmail->getEmail());
        $this->assertIsString($savedEmail->getEmail());
    }

    public function testSetEmail(): void
    {
        $email = 'test email';
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setEmail($email));
        $this->assertSame($email, $savedEmail->getEmail());
    }

    public function testGetType(): void
    {
        $type = SavedEmailTypeEnum::INVITATION;
        $savedEmail = new SavedEmail();
        $savedEmail->setType($type);
        $this->assertSame($type, $savedEmail->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(2, SavedEmail::getTypeFormChoices());
        $this->assertIsArray(SavedEmail::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(2, SavedEmail::getTypeValidationChoices());
        $this->assertIsArray(SavedEmail::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = SavedEmailTypeEnum::INVITATION;
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setType($type));
        $this->assertSame($type, $savedEmail->getType());
    }
}
