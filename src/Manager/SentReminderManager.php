<?php

namespace App\Manager;

use App\Entity\SentReminder;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SentReminderManager
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

    public function bulkSave(array $sentReminders, int $saveEvery = 100): self
    {
        $i = 1;
        foreach ($sentReminders as $sentReminder) {
            $this->save($sentReminder, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(SentReminder $sentReminder): self
    {
        $this->entityManager->remove($sentReminder);
        $this->entityManager->flush();

        return $this;
    }

    public function save(SentReminder $sentReminder, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $sentReminder->getId()) {
            $sentReminder->setCreatedAt($date);
        }
        $sentReminder->setUpdatedAt($date);

        $errors = $this->validate($sentReminder);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$sentReminder);
        }

        $this->entityManager->persist($sentReminder);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(SentReminder $sentReminder): self
    {
        $date = new DateTimeImmutable();
        $sentReminder->setDeletedAt($date);

        $this->entityManager->persist($sentReminder);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(SentReminder $sentReminder): self
    {
        $sentReminder->setDeletedAt(null);

        $this->entityManager->persist($sentReminder);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(SentReminder $sentReminder): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($sentReminder, null, ['system']);

        return $errors;
    }
}