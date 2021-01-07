<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\UserQuestionnaire;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserQuestionnaireManager
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

    public function bulkSave(array $userQuestionnaires, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($userQuestionnaires as $userQuestionnaire) {
            $this->save($userQuestionnaire, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(UserQuestionnaire $userQuestionnaire): self
    {
        $this->entityManager->remove($userQuestionnaire);
        $this->entityManager->flush();

        return $this;
    }

    public function save(UserQuestionnaire $userQuestionnaire, string $actor, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $userQuestionnaire->getId()) {
            $userQuestionnaire->setCreatedAt($date);
            $userQuestionnaire->setCreatedBy($actor);
        }
        $userQuestionnaire->setUpdatedAt($date);
        $userQuestionnaire->setUpdatedBy($actor);

        $errors = $this->validate($userQuestionnaire);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$userQuestionnaire);
        }

        $this->entityManager->persist($userQuestionnaire);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(UserQuestionnaire $userQuestionnaire, string $actor): self
    {
        $date = new DateTimeImmutable();
        $userQuestionnaire->setDeletedAt($date);
        $userQuestionnaire->setDeletedBy($actor);

        $this->entityManager->persist($userQuestionnaire);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(UserQuestionnaire $userQuestionnaire): self
    {
        $userQuestionnaire->setDeletedAt(null);
        $userQuestionnaire->setDeletedBy(null);

        $this->entityManager->persist($userQuestionnaire);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(UserQuestionnaire $userQuestionnaire): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($userQuestionnaire, null, ['system']);

        return $errors;
    }
}
