<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\SavedEmail;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

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
        $this->assertEquals($uuid, $savedEmail->__toString());
    }

    public function testGetId(): void
    {
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getUuid());
        $savedEmail->setUuid($uuid);
        $this->assertEquals($uuid, $savedEmail->getUuid());
        $this->assertIsString($savedEmail->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUuid($uuid));
        $this->assertEquals($uuid, $savedEmail->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getCreatedBy());
        $savedEmail->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $savedEmail->getCreatedBy());
        $this->assertIsString($savedEmail->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $savedEmail->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getDeletedBy());
        $savedEmail->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $savedEmail->getDeletedBy());
        $this->assertIsString($savedEmail->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $savedEmail->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getUpdatedBy());
        $savedEmail->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $savedEmail->getUpdatedBy());
        $this->assertIsString($savedEmail->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $savedEmail->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getCreatedAt());
        $savedEmail->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $savedEmail->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $savedEmail->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getDeletedAt());
        $savedEmail->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $savedEmail->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $savedEmail->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getUpdatedAt());
        $savedEmail->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $savedEmail->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $savedEmail->getUpdatedAt());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $savedEmail = new SavedEmail();
        $savedEmail->setUser($user);
        $this->assertEquals($user, $savedEmail->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUser($user));
        $this->assertEquals($user, $savedEmail->getUser());
    }

    public function testGetEmail(): void
    {
        $email = 'test email';
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getEmail());
        $savedEmail->setEmail($email);
        $this->assertEquals($email, $savedEmail->getEmail());
        $this->assertIsString($savedEmail->getEmail());
    }

    public function testSetEmail(): void
    {
        $email = 'test email';
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setEmail($email));
        $this->assertEquals($email, $savedEmail->getEmail());
    }

    public function testGetType(): void
    {
        $type = SavedEmail::TYPE_INVITATION;
        $savedEmail = new SavedEmail();
        $savedEmail->setType($type);
        $this->assertEquals($type, $savedEmail->getType());
        $this->assertIsString($savedEmail->getType());
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
        $type = SavedEmail::TYPE_INVITATION;
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setType($type));
        $this->assertEquals($type, $savedEmail->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setType($type));
    }
}
