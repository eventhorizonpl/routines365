<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use ApiPlatform\Core\Serializer\AbstractItemNormalizer;
use App\Entity\Note;
use App\Factory\NoteFactory;
use App\Repository\RoutineRepository;
use Symfony\Component\Security\Core\Security;

final class NoteCollectionInputDataTransformer implements DataTransformerInterface
{
    public function __construct(
        private NoteFactory $noteFactory,
        private RoutineRepository $routineRepository,
        private Security $security
    ) {
    }

    public function transform($object, string $to, array $context = []): Note
    {
        if (isset($context[AbstractItemNormalizer::OBJECT_TO_POPULATE])) {
            $note = $context[AbstractItemNormalizer::OBJECT_TO_POPULATE];
        } else {
            $note = $this->noteFactory->createNote();
        }

        $note
            ->setUser($this->security->getUser())
            ->setContent($object->content)
            ->setTitle($object->title)
        ;

        if (null !== $object->routine) {
            $routine = $this->routineRepository->findOneByUuid($object->routine);
            if (null !== $routine) {
                $note->setRoutine($routine);
            }
        }

        return $note;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof Note) {
            return false;
        }

        return (Note::class === $to) && (null !== ($context['input']['class'] ?? null));
    }
}
