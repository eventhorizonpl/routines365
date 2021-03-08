<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Quote;
use App\Factory\QuoteFactory;
use App\Manager\QuoteManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class QuoteFaker
{
    private Generator $faker;

    public function __construct(
        private QuoteFactory $quoteFactory,
        private QuoteManager $quoteManager
    ) {
        $this->faker = Factory::create();
    }

    public function createQuote(
        ?string $author = null,
        ?string $content = null,
        ?bool $isVisible = null
    ): Quote {
        if (null === $author) {
            $author = (string) $this->faker->word;
        }

        if (null === $content) {
            $content = (string) $this->faker->text;
        }

        if (null === $isVisible) {
            $isVisible = (bool) $this->faker->boolean;
        }

        $quote = $this->quoteFactory->createQuoteWithRequired(
            $author,
            $content,
            $isVisible
        );

        return $quote;
    }

    public function createQuotePersisted(
        ?string $author = null,
        ?string $content = null,
        ?bool $isVisible = null
    ): Quote {
        $quote = $this->createQuote(
            $author,
            $content,
            $isVisible
        );
        $this->quoteManager->save($quote, (string) Uuid::v4());

        return $quote;
    }
}
