<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Question;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionManager
{
    private AnswerManager $answerManager;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(
        AnswerManager $answerManager,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->answerManager = $answerManager;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function bulkSave(array $questions, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($questions as $question) {
            $this->save($question, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Question $question): self
    {
        $this->entityManager->remove($question);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Question $question, string $actor, bool $flush = true, bool $saveDependencies = false): self
    {
        $date = new DateTimeImmutable();
        if (null === $question->getId()) {
            $question->setCreatedAt($date);
            $question->setCreatedBy($actor);
        }
        $question->setUpdatedAt($date);
        $question->setUpdatedBy($actor);

        if (true === $saveDependencies) {
            foreach ($question->getAnswers() as $answer) {
                $this->answerManager->save($answer, $actor, false, true);
            }
        }

        $errors = $this->validate($question);
        if (0 !== count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $question));
        }

        $this->entityManager->persist($question);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Question $question, string $actor): self
    {
        $date = new DateTimeImmutable();
        $question->setDeletedAt($date);
        $question->setDeletedBy($actor);

        $this->entityManager->persist($question);
        $this->entityManager->flush();

        foreach ($question->getAnswers() as $answer) {
            $this->answerManager->softDelete($answer, $actor);
        }

        return $this;
    }

    public function undelete(Question $question): self
    {
        $question->setDeletedAt(null);
        $question->setDeletedBy(null);

        $this->entityManager->persist($question);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Question $question): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($question, null, ['system']);

        return $errors;
    }
}
