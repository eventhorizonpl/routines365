<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Contact;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactManager
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

    public function bulkSave(array $contacts, string $actor = null, int $saveEvery = 100): self
    {
        $i = 1;
        foreach ($contacts as $contact) {
            $this->save($contact, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Contact $contact): self
    {
        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Contact $contact, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $contact->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $contact->getId()) {
            $contact->setCreatedAt($date);
            $contact->setCreatedBy($actor);
        }
        $contact->setUpdatedAt($date);
        $contact->setUpdatedBy($actor);

        $errors = $this->validate($contact);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$contact);
        }

        $this->entityManager->persist($contact);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Contact $contact, string $actor): self
    {
        $date = new DateTimeImmutable();
        $contact->setDeletedAt($date);
        $contact->setDeletedBy($actor);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Contact $contact): self
    {
        $contact->setDeletedAt(null);
        $contact->setDeletedBy(null);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Contact $contact): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($contact, null, ['system']);

        return $errors;
    }
}
