<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Note;
use App\Manager\NoteManager;
use Symfony\Component\Security\Core\Security;

final class NoteDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private NoteManager $noteManager,
        private Security $security
    ) {
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Note;
    }

    public function persist($data, array $context = []): Note
    {
        $this->noteManager->save($data, (string) $this->security->getUser());

        return $data;
    }

    public function remove($data, array $context = []): void
    {
        $this->noteManager->softDelete($data, (string) $this->security->getUser());
    }
}
