<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Note;
use App\Event\UserLastActivityUpdate;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NoteManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $notes, ?string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($notes as $note) {
            $this->save($note, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Note $note): self
    {
        $this->entityManager->remove($note);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Note $note, ?string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $note->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $note->getId()) {
            $note->setCreatedAt($date);
            $note->setCreatedBy($actor);
        }
        $note->setUpdatedAt($date);
        $note->setUpdatedBy($actor);

        $errors = $this->validate($note);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $note));
        }

        $this->entityManager->persist($note);

        if (true === $flush) {
            $this->entityManager->flush();

            $event = new UserLastActivityUpdate($note->getUser());
            $this->eventDispatcher->dispatch($event, UserLastActivityUpdate::NAME);
        }

        return $this;
    }

    public function softDelete(Note $note, string $actor): self
    {
        $date = new DateTimeImmutable();
        $note->setDeletedAt($date);
        $note->setDeletedBy($actor);

        $this->entityManager->persist($note);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Note $note): self
    {
        $note->setDeletedAt(null);
        $note->setDeletedBy(null);

        $this->entityManager->persist($note);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Note $note): ConstraintViolationListInterface
    {
        return $this->validator->validate($note, null, ['system']);
    }
}
