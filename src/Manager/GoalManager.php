<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Goal;
use App\Event\UserLastActivityUpdate;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GoalManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $goals, ?string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($goals as $goal) {
            $this->save($goal, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Goal $goal): self
    {
        $this->entityManager->remove($goal);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Goal $goal, ?string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $goal->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $goal->getId()) {
            $goal->setCreatedAt($date);
            $goal->setCreatedBy($actor);
        }
        $goal->setUpdatedAt($date);
        $goal->setUpdatedBy($actor);

        if ((false === $goal->getIsCompleted())
            && (null !== $goal->getCompletedAt())
        ) {
            $goal->setCompletedAt(null);
        }

        $errors = $this->validate($goal);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $goal));
        }

        $this->entityManager->persist($goal);

        if (true === $flush) {
            $this->entityManager->flush();

            $event = new UserLastActivityUpdate($goal->getUser());
            $this->eventDispatcher->dispatch($event, UserLastActivityUpdate::NAME);
        }

        return $this;
    }

    public function softDelete(Goal $goal, string $actor): self
    {
        $date = new DateTimeImmutable();
        $goal->setDeletedAt($date);
        $goal->setDeletedBy($actor);

        $this->entityManager->persist($goal);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Goal $goal): self
    {
        $goal->setDeletedAt(null);
        $goal->setDeletedBy(null);

        $this->entityManager->persist($goal);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Goal $goal): ConstraintViolationListInterface
    {
        return $this->validator->validate($goal, null, ['system']);
    }
}
