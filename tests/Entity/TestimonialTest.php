<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Testimonial;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final class TestimonialTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $testimonial = new Testimonial();
        $testimonial->setUuid($uuid);
        $this->assertEquals($uuid, $testimonial->__toString());
    }

    public function testGetId(): void
    {
        $testimonial = new Testimonial();
        $this->assertEquals(null, $testimonial->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $testimonial = new Testimonial();
        $this->assertEquals(null, $testimonial->getUuid());
        $testimonial->setUuid($uuid);
        $this->assertEquals($uuid, $testimonial->getUuid());
        $this->assertIsString($testimonial->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setUuid($uuid));
        $this->assertEquals($uuid, $testimonial->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $testimonial = new Testimonial();
        $this->assertEquals(null, $testimonial->getCreatedBy());
        $testimonial->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $testimonial->getCreatedBy());
        $this->assertIsString($testimonial->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $testimonial->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $testimonial = new Testimonial();
        $this->assertEquals(null, $testimonial->getDeletedBy());
        $testimonial->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $testimonial->getDeletedBy());
        $this->assertIsString($testimonial->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $testimonial->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $testimonial = new Testimonial();
        $this->assertEquals(null, $testimonial->getUpdatedBy());
        $testimonial->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $testimonial->getUpdatedBy());
        $this->assertIsString($testimonial->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $testimonial->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $testimonial = new Testimonial();
        $this->assertEquals(null, $testimonial->getCreatedAt());
        $testimonial->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $testimonial->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $testimonial->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $testimonial = new Testimonial();
        $this->assertEquals(null, $testimonial->getDeletedAt());
        $testimonial->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $testimonial->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $testimonial->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $testimonial = new Testimonial();
        $this->assertEquals(null, $testimonial->getUpdatedAt());
        $testimonial->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $testimonial->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $testimonial->getUpdatedAt());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $testimonial = new Testimonial();
        $testimonial->setUser($user);
        $this->assertEquals($user, $testimonial->getUser());
    }

    public function testSetUser(): void
    {
        $user = new User();
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setUser($user));
        $this->assertEquals($user, $testimonial->getUser());
    }

    public function testGetContent(): void
    {
        $content = 'test content';
        $testimonial = new Testimonial();
        $testimonial->setContent($content);
        $this->assertEquals($content, $testimonial->getContent());
        $this->assertIsString($testimonial->getContent());
    }

    public function testSetContent(): void
    {
        $content = 'test content';
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setContent($content));
        $this->assertEquals($content, $testimonial->getContent());
    }

    public function testGetSignature(): void
    {
        $signature = 'test signature';
        $testimonial = new Testimonial();
        $this->assertEquals(null, $testimonial->getSignature());
        $testimonial->setSignature($signature);
        $this->assertEquals($signature, $testimonial->getSignature());
        $this->assertIsString($testimonial->getSignature());
    }

    public function testSetSignature(): void
    {
        $signature = 'test signature';
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setSignature($signature));
        $this->assertEquals($signature, $testimonial->getSignature());
    }

    public function testGetStatus(): void
    {
        $status = Testimonial::STATUS_NEW;
        $testimonial = new Testimonial();
        $testimonial->setStatus($status);
        $this->assertEquals($status, $testimonial->getStatus());
        $this->assertIsString($testimonial->getStatus());
    }

    public function testGetStatusFormChoices(): void
    {
        $this->assertCount(3, Testimonial::getStatusFormChoices());
        $this->assertIsArray(Testimonial::getStatusFormChoices());
    }

    public function testGetStatusValidationChoices(): void
    {
        $this->assertCount(3, Testimonial::getStatusValidationChoices());
        $this->assertIsArray(Testimonial::getStatusValidationChoices());
    }

    public function testSetStatus(): void
    {
        $status = Testimonial::STATUS_NEW;
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setStatus($status));
        $this->assertEquals($status, $testimonial->getStatus());
    }

    public function testSetStatusException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $status = 'wrong status';
        $testimonial = new Testimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial->setStatus($status));
    }
}
