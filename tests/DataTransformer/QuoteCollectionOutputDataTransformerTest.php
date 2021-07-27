<?php

declare(strict_types=1);

namespace App\Tests\DataTransformer;

use App\DataTransformer\QuoteCollectionOutputDataTransformer;
use App\Dto\QuoteCollectionOutput;
use App\Entity\Quote;
use App\Faker\QuoteFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class QuoteCollectionOutputDataTransformerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuoteCollectionOutputDataTransformer $quoteCollectionOutputDataTransformer;
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;

    protected function tearDown(): void
    {
        $this->quoteCollectionOutputDataTransformer = null;
        $this->quoteFaker = null;

        parent::tearDown();
    }

    public function testSupportsTransformation(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuote();

        $this->assertFalse($this->quoteCollectionOutputDataTransformer->supportsTransformation($quote, Quote::class));
        $this->assertTrue($this->quoteCollectionOutputDataTransformer->supportsTransformation($quote, QuoteCollectionOutput::class));
    }

    public function testTransform(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuote();

        $quoteCollectionOutput = $this->quoteCollectionOutputDataTransformer->transform($quote, QuoteCollectionOutput::class);
        $this->assertInstanceOf(QuoteCollectionOutput::class, $quoteCollectionOutput);
        $this->assertSame($quote->getUuid(), $quoteCollectionOutput->uuid);
        $this->assertSame($quote->getAuthor(), $quoteCollectionOutput->author);
        $this->assertSame($quote->getContent(), $quoteCollectionOutput->content);
    }
}
