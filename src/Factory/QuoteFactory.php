<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Quote;
use Symfony\Component\Uid\Uuid;

class QuoteFactory
{
    public function createQuote(): Quote
    {
        $quote = new Quote();
        $quote->setUuid(Uuid::v4());

        return $quote;
    }

    public function createQuoteWithRequired(
        string $author,
        string $content,
        bool $isVisible
    ): Quote {
        $quote = $this->createQuote();

        $quote
            ->setAuthor($author)
            ->setContent($content)
            ->setIsVisible($isVisible);

        return $quote;
    }
}
