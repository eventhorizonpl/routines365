<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Quote;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 */
final class QuoteTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote);
    }

    public function testToString(): void
    {
        $author = 'test author';
        $content = 'test content';
        $quote = new Quote();
        $quote->setAuthor($author);
        $quote->setContent($content);
        $this->assertSame('"'.$content.'" - '.$author, $quote->__toString());
    }

    public function testGetId(): void
    {
        $quote = new Quote();
        $this->assertNull($quote->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertNull($quote->getUuid());
        $quote->setUuid($uuid);
        $this->assertSame($uuid, $quote->getUuid());
        $this->assertIsString($quote->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setUuid($uuid));
        $this->assertSame($uuid, $quote->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertNull($quote->getCreatedBy());
        $quote->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $quote->getCreatedBy());
        $this->assertIsString($quote->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $quote->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertNull($quote->getDeletedBy());
        $quote->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $quote->getDeletedBy());
        $this->assertIsString($quote->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $quote->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertNull($quote->getUpdatedBy());
        $quote->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $quote->getUpdatedBy());
        $this->assertIsString($quote->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $quote->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertNull($quote->getCreatedAt());
        $quote->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $quote->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $quote->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertNull($quote->getDeletedAt());
        $quote->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $quote->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $quote->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertNull($quote->getUpdatedAt());
        $quote->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $quote->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $quote->getUpdatedAt());
    }

    public function testGetIsVisible(): void
    {
        $isVisible = true;
        $quote = new Quote();
        $this->assertFalse($quote->getIsVisible());
        $quote->setIsVisible($isVisible);
        $this->assertSame($isVisible, $quote->getIsVisible());
        $this->assertIsBool($quote->getIsVisible());
    }

    public function testSetIsVisible(): void
    {
        $isVisible = true;
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setIsVisible($isVisible));
        $this->assertSame($isVisible, $quote->getIsVisible());
    }

    public function testGetAuthor(): void
    {
        $author = 'test author';
        $quote = new Quote();
        $this->assertSame('', $quote->getAuthor());
        $quote->setAuthor($author);
        $this->assertSame($author, $quote->getAuthor());
        $this->assertIsString($quote->getAuthor());
    }

    public function testSetAuthor(): void
    {
        $author = 'test author';
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setAuthor($author));
        $this->assertSame($author, $quote->getAuthor());
    }

    public function testGetContent(): void
    {
        $content = 'test content';
        $quote = new Quote();
        $this->assertSame('', $quote->getContent());
        $quote->setContent($content);
        $this->assertSame($content, $quote->getContent());
        $this->assertIsString($quote->getContent());
    }

    public function testSetContent(): void
    {
        $content = 'test content';
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setContent($content));
        $this->assertSame($content, $quote->getContent());
    }

    public function testGetContentMd5(): void
    {
        $contentMd5 = 'testcontentmd5';
        $quote = new Quote();
        $quote->setContentMd5($contentMd5);
        $this->assertSame(md5($contentMd5), $quote->getContentMd5());
        $this->assertIsString($quote->getContentMd5());
    }

    public function testSetContentMd5(): void
    {
        $contentMd5 = 'testcontentmd5';
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setContentMd5($contentMd5));
        $this->assertSame(md5($contentMd5), $quote->getContentMd5());
    }

    public function testGetPopularity(): void
    {
        $popularity = 10;
        $quote = new Quote();
        $quote->setPopularity($popularity);
        $this->assertSame($popularity, $quote->getPopularity());
        $this->assertIsInt($quote->getPopularity());
    }

    public function testIncrementPopularity(): void
    {
        $quote = new Quote();
        $this->assertSame(0, $quote->getPopularity());
        $this->assertInstanceOf(Quote::class, $quote->incrementPopularity());
        $this->assertSame(1, $quote->getPopularity());
    }

    public function testSetPopularity(): void
    {
        $popularity = 10;
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setPopularity($popularity));
        $this->assertSame($popularity, $quote->getPopularity());
    }

    public function testGetStringLength(): void
    {
        $stringLength = 10;
        $quote = new Quote();
        $quote->setStringLength($stringLength);
        $this->assertSame($stringLength, $quote->getStringLength());
        $this->assertIsInt($quote->getStringLength());
    }

    public function testSetStringLength(): void
    {
        $stringLength = 10;
        $quote = new Quote();
        $this->assertInstanceOf(Quote::class, $quote->setStringLength($stringLength));
        $this->assertSame($stringLength, $quote->getStringLength());
    }
}
