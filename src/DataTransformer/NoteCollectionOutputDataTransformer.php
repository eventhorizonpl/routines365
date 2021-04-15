<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\NoteCollectionOutput;
use App\Entity\Note;

final class NoteCollectionOutputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): NoteCollectionOutput
    {
        $output = new NoteCollectionOutput();
        $output->uuid = $object->getUuid();
        $output->content = $object->getContent();
        if (null !== $object->getRoutine()) {
            $output->routine = $object->getRoutine()->getUuid();
        }
        $output->title = $object->getTitle();

        return $output;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return (NoteCollectionOutput::class === $to) && ($data instanceof Note);
    }
}
