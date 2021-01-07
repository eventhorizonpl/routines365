<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Answer;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnswerManager
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

    public function bulkSave(array $answers, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($answers as $answer) {
            $this->save($answer, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Answer $answer): self
    {
        $this->entityManager->remove($answer);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Answer $answer, string $actor, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $answer->getId()) {
            $answer->setCreatedAt($date);
            $answer->setCreatedBy($actor);
        }
        $answer->setUpdatedAt($date);
        $answer->setUpdatedBy($actor);

        $errors = $this->validate($answer);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$answer);
        }

        $this->entityManager->persist($answer);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Answer $answer, string $actor): self
    {
        $date = new DateTimeImmutable();
        $answer->setDeletedAt($date);
        $answer->setDeletedBy($actor);

        $this->entityManager->persist($answer);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Answer $answer): self
    {
        $answer->setDeletedAt(null);
        $answer->setDeletedBy(null);

        $this->entityManager->persist($answer);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Answer $answer): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($answer, null, ['system']);

        return $errors;
    }
}
