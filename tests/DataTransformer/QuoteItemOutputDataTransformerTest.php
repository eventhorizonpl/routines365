<?php

declare(strict_types=1);

namespace App\Tests\DataPersister;

use App\DataTransformer\QuoteItemOutputDataTransformer;
use App\Dto\QuoteItemOutput;
use App\Entity\Quote;
use App\Faker\QuoteFaker;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class QuoteItemOutputDataTransformerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuoteItemOutputDataTransformer $quoteItemOutputDataTransformer;
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;

    protected function tearDown(): void
    {
        $this->quoteItemOutputDataTransformer = null;
        $this->quoteFaker = null;

        parent::tearDown();
    }

    public function testSupportsTransformation(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuote();

        $this->assertFalse($this->quoteItemOutputDataTransformer->supportsTransformation($quote, Quote::class));
        $this->assertTrue($this->quoteItemOutputDataTransformer->supportsTransformation($quote, QuoteItemOutput::class));
    }

    public function testTransform(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuote();

        $quoteItemOutput = $this->quoteItemOutputDataTransformer->transform($quote, QuoteItemOutput::class);
        $this->assertInstanceOf(QuoteItemOutput::class, $quoteItemOutput);
        $this->assertSame($quote->getUuid(), $quoteItemOutput->uuid);
        $this->assertSame($quote->getAuthor(), $quoteItemOutput->author);
        $this->assertSame($quote->getContent(), $quoteItemOutput->content);
    }
}
