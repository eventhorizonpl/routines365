<?php

namespace App\Tests\Entity;

use App\Entity\SavedEmail;
use App\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class SavedEmailTest extends TestCase
{
    public function testConstruct()
    {
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail);
    }

    public function testToString()
    {
        $uuid = Uuid::v4();
        $savedEmail = new SavedEmail();
        $savedEmail->setUuid($uuid);
        $this->assertEquals($uuid, $savedEmail->__toString());
    }

    public function testGetId()
    {
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getId());
    }

    public function testGetUuid()
    {
        $uuid = Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getUuid());
        $savedEmail->setUuid($uuid);
        $this->assertEquals($uuid, $savedEmail->getUuid());
        $this->assertIsString($savedEmail->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUuid($uuid));
        $this->assertEquals($uuid, $savedEmail->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getCreatedBy());
        $savedEmail->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $savedEmail->getCreatedBy());
        $this->assertIsString($savedEmail->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $savedEmail->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getDeletedBy());
        $savedEmail->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $savedEmail->getDeletedBy());
        $this->assertIsString($savedEmail->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $savedEmail->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getUpdatedBy());
        $savedEmail->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $savedEmail->getUpdatedBy());
        $this->assertIsString($savedEmail->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = Uuid::v4();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $savedEmail->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getCreatedAt());
        $savedEmail->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $savedEmail->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $savedEmail->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getDeletedAt());
        $savedEmail->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $savedEmail->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $savedEmail->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getUpdatedAt());
        $savedEmail->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $savedEmail->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $savedEmail->getUpdatedAt());
    }

    public function testGetUser()
    {
        $user = new User();
        $savedEmail = new SavedEmail();
        $savedEmail->setUser($user);
        $this->assertEquals($user, $savedEmail->getUser());
    }

    public function testSetUser()
    {
        $user = new User();
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setUser($user));
        $this->assertEquals($user, $savedEmail->getUser());
    }

    public function testGetEmail()
    {
        $email = 'test email';
        $savedEmail = new SavedEmail();
        $this->assertEquals(null, $savedEmail->getEmail());
        $savedEmail->setEmail($email);
        $this->assertEquals($email, $savedEmail->getEmail());
        $this->assertIsString($savedEmail->getEmail());
    }

    public function testSetEmail()
    {
        $email = 'test email';
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setEmail($email));
        $this->assertEquals($email, $savedEmail->getEmail());
    }

    public function testGetType()
    {
        $type = SavedEmail::TYPE_INVITATION;
        $savedEmail = new SavedEmail();
        $savedEmail->setType($type);
        $this->assertEquals($type, $savedEmail->getType());
        $this->assertIsString($savedEmail->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(2, SavedEmail::getTypeFormChoices());
        $this->assertIsArray(SavedEmail::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(2, SavedEmail::getTypeValidationChoices());
        $this->assertIsArray(SavedEmail::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = SavedEmail::TYPE_INVITATION;
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(SavedEmail::class, $savedEmail->setType($type));
        $this->assertEquals($type, $savedEmail->getType());
    }
}
