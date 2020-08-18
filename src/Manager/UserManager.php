<?php

namespace App\Manager;

use App\Entity\User;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private AccountManager $accountManager;
    private CompletedRoutineManager $completedRoutineManager;
    private EntityManagerInterface $entityManager;
    private GoalManager $goalManager;
    private NoteManager $noteManager;
    private ProfileManager $profileManager;
    private ReminderManager $reminderManager;
    private RoutineManager $routineManager;
    private ValidatorInterface $validator;

    public function __construct(
        AccountManager $accountManager,
        CompletedRoutineManager $completedRoutineManager,
        EntityManagerInterface $entityManager,
        GoalManager $goalManager,
        NoteManager $noteManager,
        ProfileManager $profileManager,
        ReminderManager $reminderManager,
        RoutineManager $routineManager,
        ValidatorInterface $validator
    ) {
        $this->accountManager = $accountManager;
        $this->completedRoutineManager = $completedRoutineManager;
        $this->entityManager = $entityManager;
        $this->goalManager = $goalManager;
        $this->noteManager = $noteManager;
        $this->profileManager = $profileManager;
        $this->reminderManager = $reminderManager;
        $this->routineManager = $routineManager;
        $this->validator = $validator;
    }

    public function bulkSave(array $users, string $actor = null, int $saveEvery = 100): self
    {
        $i = 1;
        foreach ($users as $user) {
            $this->save($user, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(User $user): self
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this;
    }

    public function save(User $user, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = $user->getUuid();
        }
        $date = new DateTimeImmutable();
        if (null === $user->getId()) {
            $user->setCreatedAt($date);
            $user->setCreatedBy($actor);
        }
        $user->setUpdatedAt($date);
        $user->setUpdatedBy($actor);

        $errors = $this->validate($user);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors);
        }

        $this->entityManager->persist($user);
        $this->accountManager->save($user->getAccount(), $actor, false);
        $this->profileManager->save($user->getProfile(), $actor, false);
        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(User $user, string $actor): self
    {
        $date = new DateTimeImmutable();
        $user->setDeletedAt($date);
        $user->setDeletedBy($actor);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->accountManager->softDelete($user->getAccount(), $actor);

        foreach ($user->getCompletedRoutines() as $completedRoutine) {
            $this->completedRoutineManager->softDelete($completedRoutine, $actor);
        }

        foreach ($user->getGoals() as $goal) {
            $this->goalManager->softDelete($goal, $actor);
        }

        foreach ($user->getNotes() as $note) {
            $this->noteManager->softDelete($note, $actor);
        }

        $this->profileManager->softDelete($user->getProfile(), $actor);

        foreach ($user->getReminders() as $reminder) {
            $this->reminderManager->softDelete($reminder, $actor);
        }

        foreach ($user->getRoutines() as $routine) {
            $this->routineManager->softDelete($routine, $actor);
        }

        return $this;
    }

    public function undelete(User $user): self
    {
        $user->setDeletedAt(null);
        $user->setDeletedBy(null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->accountManager->undelete($user->getAccount());
        $this->profileManager->undelete($user->getProfile());

        return $this;
    }

    public function validate(User $user): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($user, null, ['system']);

        return $errors;
    }
}
