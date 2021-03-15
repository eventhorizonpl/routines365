<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\ReminderMessage;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReminderMessageManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $reminderMessages, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($reminderMessages as $reminderMessage) {
            $this->save($reminderMessage, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(ReminderMessage $reminderMessage): self
    {
        $this->entityManager->remove($reminderMessage);
        $this->entityManager->flush();

        return $this;
    }

    public function save(ReminderMessage $reminderMessage, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $reminderMessage->getId()) {
            $reminderMessage->setCreatedAt($date);
        }
        $reminderMessage->setUpdatedAt($date);

        $errors = $this->validate($reminderMessage);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $reminderMessage));
        }

        $this->entityManager->persist($reminderMessage);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(ReminderMessage $reminderMessage): self
    {
        $date = new DateTimeImmutable();
        $reminderMessage->setDeletedAt($date);

        $this->entityManager->persist($reminderMessage);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(ReminderMessage $reminderMessage): self
    {
        $reminderMessage->setDeletedAt(null);

        $this->entityManager->persist($reminderMessage);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(ReminderMessage $reminderMessage): ConstraintViolationListInterface
    {
        return $this->validator->validate($reminderMessage, null, ['system']);
    }
}
