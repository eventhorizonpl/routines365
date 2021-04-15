<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Routine;
use App\Manager\RoutineManager;
use Symfony\Component\Security\Core\Security;

final class RoutineDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(
        private RoutineManager $routineManager,
        private Security $security
    ) {
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Routine;
    }

    public function persist($data, array $context = []): Routine
    {
        $this->routineManager->save($data, (string) $this->security->getUser());

        return $data;
    }

    public function remove($data, array $context = []): void
    {
        $this->routineManager->softDelete($data, (string) $this->security->getUser());
    }
}
