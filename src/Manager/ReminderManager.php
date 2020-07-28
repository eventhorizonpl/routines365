<?php

namespace App\Manager;

use App\Entity\Reminder;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReminderManager
{
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function bulkSave(array $reminders, string $actor = null, int $saveEvery = 100): self
    {
        $i = 1;
        foreach ($reminders as $reminder) {
            $this->save($reminder, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Reminder $reminder): self
    {
        $this->entityManager->remove($reminder);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Reminder $reminder, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = $reminder->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $reminder->getId()) {
            $reminder->setCreatedAt($date);
            $reminder->setCreatedBy($actor);
        }
        $reminder->setUpdatedAt($date);
        $reminder->setUpdatedBy($actor);

        if ((null === $reminder->getPreviousDate()) && (null === $reminder->getNextDate())) {
            $reminder->setPreviousDate($date);
        } elseif (null !== $reminder->getNextDate()) {
            $reminder->setPreviousDate($reminder->getNextDate());
        }

        if (null === $reminder->getNextDate()) {
            $reminder->setNextDate($date);
        }

        $errors = $this->validate($reminder);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$reminder);
        }

        $this->entityManager->persist($reminder);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Reminder $reminder, string $actor): self
    {
        $date = new DateTimeImmutable();
        $reminder->setDeletedAt($date);
        $reminder->setDeletedBy($actor);

        $this->entityManager->persist($reminder);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Reminder $reminder): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($reminder, null, ['system']);

        return $errors;
    }
}
