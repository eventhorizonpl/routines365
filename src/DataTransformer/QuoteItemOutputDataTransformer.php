<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\QuoteItemOutput;
use App\Entity\Quote;

final class QuoteItemOutputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): QuoteItemOutput
    {
        $output = new QuoteItemOutput();
        $output->uuid = $object->getUuid();
        $output->author = $object->getAuthor();
        $output->content = $object->getContent();

        return $output;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return (QuoteItemOutput::class === $to) && ($data instanceof Quote);
    }
}
