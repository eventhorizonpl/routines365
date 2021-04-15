<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\NoteItemOutput;
use App\Entity\Note;

final class NoteItemOutputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): NoteItemOutput
    {
        $output = new NoteItemOutput();
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
        return (NoteItemOutput::class === $to) && ($data instanceof Note);
    }
}
