<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\UserQuestionnaireAnswer;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserQuestionnaireAnswerManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $userQuestionnaireAnswers, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($userQuestionnaireAnswers as $userQuestionnaireAnswer) {
            $this->save($userQuestionnaireAnswer, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(UserQuestionnaireAnswer $userQuestionnaireAnswer): self
    {
        $this->entityManager->remove($userQuestionnaireAnswer);
        $this->entityManager->flush();

        return $this;
    }

    public function save(UserQuestionnaireAnswer $userQuestionnaireAnswer, string $actor, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $userQuestionnaireAnswer->getId()) {
            $userQuestionnaireAnswer->setCreatedAt($date);
            $userQuestionnaireAnswer->setCreatedBy($actor);
        }
        $userQuestionnaireAnswer->setUpdatedAt($date);
        $userQuestionnaireAnswer->setUpdatedBy($actor);

        $errors = $this->validate($userQuestionnaireAnswer);
        if (0 !== count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $userQuestionnaireAnswer));
        }

        $this->entityManager->persist($userQuestionnaireAnswer);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(UserQuestionnaireAnswer $userQuestionnaireAnswer, string $actor): self
    {
        $date = new DateTimeImmutable();
        $userQuestionnaireAnswer->setDeletedAt($date);
        $userQuestionnaireAnswer->setDeletedBy($actor);

        $this->entityManager->persist($userQuestionnaireAnswer);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(UserQuestionnaireAnswer $userQuestionnaireAnswer): self
    {
        $userQuestionnaireAnswer->setDeletedAt(null);
        $userQuestionnaireAnswer->setDeletedBy(null);

        $this->entityManager->persist($userQuestionnaireAnswer);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(UserQuestionnaireAnswer $userQuestionnaireAnswer): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($userQuestionnaireAnswer, null, ['system']);

        return $errors;
    }
}
