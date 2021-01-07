<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Questionnaire;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionnaireManager
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

    public function bulkSave(array $questionnaires, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($questionnaires as $questionnaire) {
            $this->save($questionnaire, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Questionnaire $questionnaire): self
    {
        $this->entityManager->remove($questionnaire);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Questionnaire $questionnaire, string $actor, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $questionnaire->getId()) {
            $questionnaire->setCreatedAt($date);
            $questionnaire->setCreatedBy($actor);
        }
        $questionnaire->setUpdatedAt($date);
        $questionnaire->setUpdatedBy($actor);

        $errors = $this->validate($questionnaire);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$questionnaire);
        }

        $this->entityManager->persist($questionnaire);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Questionnaire $questionnaire, string $actor): self
    {
        $date = new DateTimeImmutable();
        $questionnaire->setDeletedAt($date);
        $questionnaire->setDeletedBy($actor);

        $this->entityManager->persist($questionnaire);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Questionnaire $questionnaire): self
    {
        $questionnaire->setDeletedAt(null);
        $questionnaire->setDeletedBy(null);

        $this->entityManager->persist($questionnaire);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Questionnaire $questionnaire): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($questionnaire, null, ['system']);

        return $errors;
    }
}
