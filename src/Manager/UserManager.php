<?php

declare(strict_types=1);

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
    private AccountOperationManager $accountOperationManager;
    private CompletedRoutineManager $completedRoutineManager;
    private ContactManager $contactManager;
    private EntityManagerInterface $entityManager;
    private GoalManager $goalManager;
    private NoteManager $noteManager;
    private ProfileManager $profileManager;
    private ProjectManager $projectManager;
    private ReminderManager $reminderManager;
    private RewardManager $rewardManager;
    private RoutineManager $routineManager;
    private SavedEmailManager $savedEmailManager;
    private TestimonialManager $testimonialManager;
    private UserKytManager $userKytManager;
    private ValidatorInterface $validator;

    public function __construct(
        AccountManager $accountManager,
        AccountOperationManager $accountOperationManager,
        CompletedRoutineManager $completedRoutineManager,
        ContactManager $contactManager,
        EntityManagerInterface $entityManager,
        GoalManager $goalManager,
        NoteManager $noteManager,
        ProfileManager $profileManager,
        ProjectManager $projectManager,
        ReminderManager $reminderManager,
        RewardManager $rewardManager,
        RoutineManager $routineManager,
        SavedEmailManager $savedEmailManager,
        TestimonialManager $testimonialManager,
        UserKytManager $userKytManager,
        ValidatorInterface $validator
    ) {
        $this->accountManager = $accountManager;
        $this->accountOperationManager = $accountOperationManager;
        $this->completedRoutineManager = $completedRoutineManager;
        $this->contactManager = $contactManager;
        $this->entityManager = $entityManager;
        $this->goalManager = $goalManager;
        $this->noteManager = $noteManager;
        $this->profileManager = $profileManager;
        $this->projectManager = $projectManager;
        $this->reminderManager = $reminderManager;
        $this->rewardManager = $rewardManager;
        $this->routineManager = $routineManager;
        $this->savedEmailManager = $savedEmailManager;
        $this->testimonialManager = $testimonialManager;
        $this->userKytManager = $userKytManager;
        $this->validator = $validator;
    }

    public function bulkSave(array $users, string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
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

    public function save(User $user, string $actor = null, bool $flush = true, bool $saveDependencies = false): self
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

        if (null !== $user->getTestimonial()) {
            $this->testimonialManager->save($user->getTestimonial(), $actor, false);
        }

        if (null !== $user->getUserKyt()) {
            $this->userKytManager->save($user->getUserKyt(), $actor, false);
        }

        if (true === $saveDependencies) {
            foreach ($user->getAccount()->getAccountOperations() as $accountOperation) {
                $this->accountOperationManager->save($accountOperation, $actor, false);
            }

            foreach ($user->getContacts() as $contact) {
                $this->contactManager->save($contact, $actor, false);
            }

            foreach ($user->getRoutines() as $routine) {
                $this->routineManager->save($routine, $actor, false);
            }

            foreach ($user->getCompletedRoutines() as $completedRoutine) {
                $this->completedRoutineManager->save($completedRoutine, $actor, false);
            }

            foreach ($user->getGoals() as $goal) {
                $this->goalManager->save($goal, $actor, false);
            }

            foreach ($user->getNotes() as $note) {
                $this->noteManager->save($note, $actor, false);
            }

            foreach ($user->getProjects() as $project) {
                $this->projectManager->save($project, $actor, false);
            }

            foreach ($user->getReminders() as $reminder) {
                $this->reminderManager->save($reminder, $actor, false);
            }

            foreach ($user->getRewards() as $reward) {
                $this->rewardManager->save($reward, $actor, false);
            }

            foreach ($user->getSavedEmails() as $savedEmail) {
                $this->savedEmailManager->save($savedEmail, $actor, false);
            }
        }

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

        foreach ($user->getContacts() as $contact) {
            $this->contactManager->softDelete($contact, $actor);
        }

        foreach ($user->getGoals() as $goal) {
            $this->goalManager->softDelete($goal, $actor);
        }

        foreach ($user->getNotes() as $note) {
            $this->noteManager->softDelete($note, $actor);
        }

        $this->profileManager->softDelete($user->getProfile(), $actor);

        foreach ($user->getProjects() as $project) {
            $this->projectManager->softDelete($project, $actor);
        }

        foreach ($user->getReminders() as $reminder) {
            $this->reminderManager->softDelete($reminder, $actor);
        }

        foreach ($user->getRewards() as $reward) {
            $this->rewardManager->softDelete($reward, $actor);
        }

        foreach ($user->getRoutines() as $routine) {
            $this->routineManager->softDelete($routine, $actor);
        }

        foreach ($user->getSavedEmails() as $savedEmail) {
            $this->savedEmailManager->softDelete($savedEmail, $actor);
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
