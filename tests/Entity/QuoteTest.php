<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Quote;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

final class QuoteTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote);
    }

    public function testToString()
    {
        $author = 'test author';
        $content = 'test content';
        $quote = new Quote();
        $quote->setAuthor($author);
        $quote->setContent($content);
        $this->assertEquals('"'.$content.'" - '.$author, $quote->__toString());
    }

    public function testGetId()
    {
        $quote = new Quote();
        $this->assertEquals(null, $quote->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertEquals(null, $quote->getUuid());
        $quote->setUuid($uuid);
        $this->assertEquals($uuid, $quote->getUuid());
        $this->assertIsString($quote->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setUuid($uuid));
        $this->assertEquals($uuid, $quote->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertEquals(null, $quote->getCreatedBy());
        $quote->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $quote->getCreatedBy());
        $this->assertIsString($quote->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $quote->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertEquals(null, $quote->getDeletedBy());
        $quote->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $quote->getDeletedBy());
        $this->assertIsString($quote->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $quote->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertEquals(null, $quote->getUpdatedBy());
        $quote->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $quote->getUpdatedBy());
        $this->assertIsString($quote->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $quote->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertEquals(null, $quote->getCreatedAt());
        $quote->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $quote->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $quote->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertEquals(null, $quote->getDeletedAt());
        $quote->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $quote->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $quote->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertEquals(null, $quote->getUpdatedAt());
        $quote->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $quote->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $quote->getUpdatedAt());
    }

    public function testGetIsVisible()
    {
        $isVisible = true;
        $quote = new Quote();
        $this->assertEquals(null, $quote->getIsVisible());
        $quote->setIsVisible($isVisible);
        $this->assertEquals($isVisible, $quote->getIsVisible());
        $this->assertIsBool($quote->getIsVisible());
    }

    public function testSetIsVisible()
    {
        $isVisible = true;
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setIsVisible($isVisible));
        $this->assertEquals($isVisible, $quote->getIsVisible());
    }

    public function testGetAuthor()
    {
        $author = 'test author';
        $quote = new Quote();
        $this->assertEquals(null, $quote->getAuthor());
        $quote->setAuthor($author);
        $this->assertEquals($author, $quote->getAuthor());
        $this->assertIsString($quote->getAuthor());
    }

    public function testSetAuthor()
    {
        $author = 'test author';
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setAuthor($author));
        $this->assertEquals($author, $quote->getAuthor());
    }

    public function testGetContent()
    {
        $content = 'test content';
        $quote = new Quote();
        $this->assertEquals(null, $quote->getContent());
        $quote->setContent($content);
        $this->assertEquals($content, $quote->getContent());
        $this->assertIsString($quote->getContent());
    }

    public function testSetContent()
    {
        $content = 'test content';
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setContent($content));
        $this->assertEquals($content, $quote->getContent());
    }

    public function testGetContentMd5()
    {
        $contentMd5 = 'testcontentmd5';
        $quote = new Quote();
        $quote->setContentMd5($contentMd5);
        $this->assertEquals(md5($contentMd5), $quote->getContentMd5());
        $this->assertIsString($quote->getContentMd5());
    }

    public function testSetContentMd5()
    {
        $contentMd5 = 'testcontentmd5';
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setContentMd5($contentMd5));
        $this->assertEquals(md5($contentMd5), $quote->getContentMd5());
    }

    public function testGetPopularity()
    {
        $popularity = 10;
        $quote = new Quote();
        $quote->setPopularity($popularity);
        $this->assertEquals($popularity, $quote->getPopularity());
        $this->assertIsInt($quote->getPopularity());
    }

    public function testIncrementPopularity()
    {
        $quote = new Quote();
        $this->assertEquals(0, $quote->getPopularity());
        $this->assertInstanceOf(Quote::class, $quote->incrementPopularity());
        $this->assertEquals(1, $quote->getPopularity());
    }

    public function testSetPopularity()
    {
        $popularity = 10;
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setPopularity($popularity));
        $this->assertEquals($popularity, $quote->getPopularity());
    }

    public function testGetStringLength()
    {
        $stringLength = 10;
        $quote = new Quote();
        $quote->setStringLength($stringLength);
        $this->assertEquals($stringLength, $quote->getStringLength());
        $this->assertIsInt($quote->getStringLength());
    }

    public function testSetStringLength()
    {
        $stringLength = 10;
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setStringLength($stringLength));
        $this->assertEquals($stringLength, $quote->getStringLength());
    }
}
