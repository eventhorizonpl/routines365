<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\SavedEmail;
use App\Event\UserLastActivityUpdate;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SavedEmailManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $savedEmails, string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($savedEmails as $savedEmail) {
            $this->save($savedEmail, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(SavedEmail $savedEmail): self
    {
        $this->entityManager->remove($savedEmail);
        $this->entityManager->flush();

        return $this;
    }

    public function save(SavedEmail $savedEmail, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $savedEmail->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $savedEmail->getId()) {
            $savedEmail->setCreatedAt($date);
            $savedEmail->setCreatedBy($actor);
        }
        $savedEmail->setUpdatedAt($date);
        $savedEmail->setUpdatedBy($actor);

        $errors = $this->validate($savedEmail);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $savedEmail));
        }

        $this->entityManager->persist($savedEmail);

        if (true === $flush) {
            $this->entityManager->flush();

            $event = new UserLastActivityUpdate($savedEmail->getUser());
            $this->eventDispatcher->dispatch($event, UserLastActivityUpdate::NAME);
        }

        return $this;
    }

    public function softDelete(SavedEmail $savedEmail, string $actor): self
    {
        $date = new DateTimeImmutable();
        $savedEmail->setDeletedAt($date);
        $savedEmail->setDeletedBy($actor);

        $this->entityManager->persist($savedEmail);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(SavedEmail $savedEmail): self
    {
        $savedEmail->setDeletedAt(null);
        $savedEmail->setDeletedBy(null);

        $this->entityManager->persist($savedEmail);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(SavedEmail $savedEmail): ConstraintViolationListInterface
    {
        return $this->validator->validate($savedEmail, null, ['system']);
    }
}
