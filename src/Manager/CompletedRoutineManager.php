<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\CompletedRoutine;
use App\Event\UserLastActivityUpdate;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CompletedRoutineManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $completedRoutines, ?string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($completedRoutines as $completedRoutine) {
            $this->save($completedRoutine, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(CompletedRoutine $completedRoutine): self
    {
        $this->entityManager->remove($completedRoutine);
        $this->entityManager->flush();

        return $this;
    }

    public function save(CompletedRoutine $completedRoutine, ?string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $completedRoutine->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $completedRoutine->getId()) {
            $completedRoutine->setCreatedAt($date);
            $completedRoutine->setCreatedBy($actor);
        }
        $completedRoutine->setUpdatedAt($date);
        $completedRoutine->setUpdatedBy($actor);

        $errors = $this->validate($completedRoutine);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $completedRoutine));
        }

        $this->entityManager->persist($completedRoutine);

        if (true === $flush) {
            $this->entityManager->flush();

            $event = new UserLastActivityUpdate($completedRoutine->getUser());
            $this->eventDispatcher->dispatch($event, UserLastActivityUpdate::NAME);
        }

        return $this;
    }

    public function softDelete(CompletedRoutine $completedRoutine, string $actor): self
    {
        $date = new DateTimeImmutable();
        $completedRoutine->setDeletedAt($date);
        $completedRoutine->setDeletedBy($actor);

        $this->entityManager->persist($completedRoutine);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(CompletedRoutine $completedRoutine): self
    {
        $completedRoutine->setDeletedAt(null);
        $completedRoutine->setDeletedBy(null);

        $this->entityManager->persist($completedRoutine);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(CompletedRoutine $completedRoutine): ConstraintViolationListInterface
    {
        return $this->validator->validate($completedRoutine, null, ['system']);
    }
}
