<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Reminder;
use App\Exception\ManagerException;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReminderManager
{
    private EntityManagerInterface $entityManager;
    private ReminderMessageManager $reminderMessageManager;
    private SentReminderManager $sentReminderManager;
    private ValidatorInterface $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ReminderMessageManager $reminderMessageManager,
        SentReminderManager $sentReminderManager,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->reminderMessageManager = $reminderMessageManager;
        $this->sentReminderManager = $sentReminderManager;
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

    public function findNextDate(Reminder $reminder): DateTimeImmutable
    {
        $hour = $reminder->getHour();

        $dateTimeNow = new DateTime();
        try {
            $dateTimeNow->setTimezone(new DateTimeZone($reminder->getUser()->getProfile()->getTimeZone()));
        } catch (Exception $e) {
        }

        $dateTime = clone $dateTimeNow;
        $dateTime->setTime($hour->format('H'), $hour->format('i'), $hour->format('s'));
        $dateTime->modify('-'.$reminder->getMinutesBefore().' minutes');

        if (Reminder::TYPE_DAILY === $reminder->getType()) {
            while ($dateTime <= $dateTimeNow) {
                $dateTime->modify('+1 day');
            }
        } else {
            if ($dateTime <= $dateTimeNow) {
                $dateTime->modify('+1 day');
            }
            while (strtolower($dateTime->format('l')) !== $reminder->getType()) {
                $dateTime->modify('+1 day');
            }
        }

        return DateTimeImmutable::createFromMutable($dateTime);
    }

    public function lock(Reminder $reminder): self
    {
        $date = new DateTimeImmutable();
        $reminder->setLockedAt($date);

        $this->entityManager->persist($reminder);
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

        $nextDateLocalTime = $this->findNextDate($reminder);
        $nextDateTmp = DateTime::createFromImmutable($nextDateLocalTime);
        $nextDateTmp->setTimezone(new DateTimeZone('UTC'));
        $nextDate = DateTimeImmutable::createFromMutable($nextDateTmp);
        $reminder->setNextDate($nextDate);
        $reminder->setNextDateLocalTime($nextDateLocalTime);

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

        foreach ($reminder->getReminderMessages() as $reminderMessage) {
            $this->reminderMessageManager->softDelete($reminderMessage);
        }

        foreach ($reminder->getSentReminders() as $sentReminder) {
            $this->sentReminderManager->softDelete($sentReminder);
        }

        return $this;
    }

    public function undelete(Reminder $reminder): self
    {
        $reminder->setDeletedAt(null);
        $reminder->setDeletedBy(null);

        $this->entityManager->persist($reminder);
        $this->entityManager->flush();

        return $this;
    }

    public function unlock(Reminder $reminder): self
    {
        $reminder->setLockedAt(null);

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
