<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\QuoteCollectionOutput;
use App\Entity\Quote;

final class QuoteCollectionOutputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): QuoteCollectionOutput
    {
        $output = new QuoteCollectionOutput();
        $output->uuid = $object->getUuid();
        $output->author = $object->getAuthor();
        $output->content = $object->getContent();

        return $output;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return (QuoteCollectionOutput::class === $to) && ($data instanceof Quote);
    }
}
