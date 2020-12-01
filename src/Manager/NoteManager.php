<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Note;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NoteManager
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

    public function bulkSave(array $notes, string $actor = null, int $saveEvery = 100): self
    {
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

    public function save(Note $note, string $actor = null, bool $flush = true): self
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
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$note);
        }

        $this->entityManager->persist($note);

        if (true === $flush) {
            $this->entityManager->flush();
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
        $errors = $this->validator->validate($note, null, ['system']);

        return $errors;
    }
}
