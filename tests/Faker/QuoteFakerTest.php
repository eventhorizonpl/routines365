<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Quote;
use App\Factory\QuoteFactory;
use App\Faker\QuoteFaker;
use App\Manager\QuoteManager;
use App\Tests\AbstractDoctrineTestCase;

final class QuoteFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?QuoteFactory $quoteFactory;
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;
    /**
     * @inject
     */
    private ?QuoteManager $quoteManager;

    protected function tearDown(): void
    {
        unset(
            $this->quoteFactory,
            $this->quoteFaker,
            $this->quoteManager
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $quoteFaker = new QuoteFaker($this->quoteFactory, $this->quoteManager);

        $this->assertInstanceOf(QuoteFaker::class, $quoteFaker);
    }

    public function testCreateQuote(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuote();
        $this->assertInstanceOf(Quote::class, $quote);
        $author = 'test author';
        $content = 'test content';
        $isVisible = true;
        $quote = $this->quoteFaker->createQuote(
            $author,
            $content,
            $isVisible
        );
        $this->assertEquals($author, $quote->getAuthor());
        $this->assertEquals($content, $quote->getContent());
        $this->assertEquals($isVisible, $quote->getIsVisible());
    }

    public function testCreateQuotePersisted(): void
    {
        $this->purge();
        $quote = $this->quoteFaker->createQuotePersisted();
        $this->assertInstanceOf(Quote::class, $quote);
        $author = 'test author';
        $content = 'test content';
        $isVisible = true;
        $quote = $this->quoteFaker->createQuotePersisted(
            $author,
            $content,
            $isVisible
        );
        $this->assertEquals($author, $quote->getAuthor());
        $this->assertEquals($content, $quote->getContent());
        $this->assertEquals($isVisible, $quote->getIsVisible());
    }
}
