<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Entity\Routine;
use App\Factory\RoutineFactory;
use Symfony\Component\Security\Core\Security;

final class RoutineCollectionInputDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private RoutineFactory $routineFactory,
        private Security $security
    ) {
    }

    public function transform($object, string $to, array $context = []): Routine
    {
        if (isset($context[AbstractItemNormalizer::OBJECT_TO_POPULATE])) {
            $routine = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
        } else {
            $routine = $this->routineFactory->createRoutine();
        }

        $routine
            ->setUser($this->security->getUser())
            ->setDescription($object->description)
            ->setIsEnabled($object->isEnabled)
            ->setName($object->name)
            ->setType($object->type)
        ;

        return $routine;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Routine) {
            return false;
        }

        return (Routine::class === $to) && (null !== ($context['input']['class'] ?? null));
    }
}
