<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Routine;
use App\Event\UserLastActivityUpdate;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RoutineManager
{
    public function __construct(
        private CompletedRoutineManager $completedRoutineManager,
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private GoalManager $goalManager,
        private NoteManager $noteManager,
        private ReminderManager $reminderManager,
        private RewardManager $rewardManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $routines, ?string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($routines as $routine) {
            $this->save($routine, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Routine $routine): self
    {
        $this->entityManager->remove($routine);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Routine $routine, ?string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $routine->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $routine->getId()) {
            $routine->setCreatedAt($date);
            $routine->setCreatedBy($actor);
        }
        $routine->setUpdatedAt($date);
        $routine->setUpdatedBy($actor);

        $errors = $this->validate($routine);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $routine));
        }

        $this->entityManager->persist($routine);

        if (true === $flush) {
            $this->entityManager->flush();

            $event = new UserLastActivityUpdate($routine->getUser());
            $this->eventDispatcher->dispatch($event, UserLastActivityUpdate::NAME);
        }

        return $this;
    }

    public function softDelete(Routine $routine, string $actor): self
    {
        $date = new DateTimeImmutable();
        $routine->setDeletedAt($date);
        $routine->setDeletedBy($actor);

        $this->entityManager->persist($routine);
        $this->entityManager->flush();

        foreach ($routine->getCompletedRoutines() as $completedRoutine) {
            $this->completedRoutineManager->softDelete($completedRoutine, $actor);
        }

        foreach ($routine->getGoals() as $goal) {
            $this->goalManager->softDelete($goal, $actor);
        }

        foreach ($routine->getNotes() as $note) {
            $this->noteManager->softDelete($note, $actor);
        }

        foreach ($routine->getReminders() as $reminder) {
            $this->reminderManager->softDelete($reminder, $actor);
        }

        foreach ($routine->getRewards() as $reward) {
            $this->rewardManager->softDelete($reward, $actor);
        }

        return $this;
    }

    public function undelete(Routine $routine): self
    {
        $routine->setDeletedAt(null);
        $routine->setDeletedBy(null);

        $this->entityManager->persist($routine);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Routine $routine): ConstraintViolationListInterface
    {
        return $this->validator->validate($routine, null, ['system']);
    }
}
