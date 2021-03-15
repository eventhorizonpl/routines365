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
    public function __construct(
        private EntityManagerInterface $entityManager,
        private QuestionManager $questionManager,
        private ValidatorInterface $validator
    ) {
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

    public function save(Questionnaire $questionnaire, string $actor, bool $flush = true, bool $saveDependencies = false): self
    {
        $date = new DateTimeImmutable();
        if (null === $questionnaire->getId()) {
            $questionnaire->setCreatedAt($date);
            $questionnaire->setCreatedBy($actor);
        }
        $questionnaire->setUpdatedAt($date);
        $questionnaire->setUpdatedBy($actor);

        if (true === $saveDependencies) {
            foreach ($questionnaire->getQuestions() as $question) {
                $this->questionManager->save($question, $actor, false, true);
            }
        }

        $errors = $this->validate($questionnaire);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $questionnaire));
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

        foreach ($questionnaire->getQuestions() as $question) {
            $this->questionManager->softDelete($question, $actor);
        }

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
        return $this->validator->validate($questionnaire, null, ['system']);
    }
}
