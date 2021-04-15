<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\RoutineItemOutput;
use App\Entity\Routine;

final class RoutineItemOutputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): RoutineItemOutput
    {
        $output = new RoutineItemOutput();
        $output->uuid = $object->getUuid();
        $output->description = $object->getDescription();
        $output->name = $object->getName();
        $output->type = $object->getType();

        return $output;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return (RoutineItemOutput::class === $to) && ($data instanceof Routine);
    }
}
