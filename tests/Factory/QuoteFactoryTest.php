<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Quote;
use App\Factory\QuoteFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

final class QuoteFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct()
    {
        $quoteFactory = new QuoteFactory();

        $this->assertInstanceOf(QuoteFactory::class, $quoteFactory);
    }

    public function testCreateQuote()
    {
        $quoteFactory = new QuoteFactory();
        $quote = $quoteFactory->createQuote();
        $this->assertInstanceOf(Quote::class, $quote);
    }

    public function testCreateQuoteWithRequired()
    {
        $author = $this->faker->sentence;
        $content = $this->faker->sentence;
        $isVisible = $this->faker->boolean;
        $quoteFactory = new QuoteFactory();
        $quote = $quoteFactory->createQuoteWithRequired(
            $author,
            $content,
            $isVisible
        );
        $this->assertInstanceOf(Quote::class, $quote);
        $this->assertEquals($author, $quote->getAuthor());
        $this->assertEquals($content, $quote->getContent());
        $this->assertEquals($isVisible, $quote->getIsVisible());
    }
}
