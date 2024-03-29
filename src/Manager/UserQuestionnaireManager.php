<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\UserQuestionnaire;
use App\Event\UserLastActivityUpdate;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserQuestionnaireManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private ValidatorInterface $validator
    ) {
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

    public function save(UserQuestionnaire $userQuestionnaire, string $actor, bool $flush = true, bool $dispatch = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $userQuestionnaire->getId()) {
            $userQuestionnaire->setCreatedAt($date);
            $userQuestionnaire->setCreatedBy($actor);
        }
        $userQuestionnaire->setUpdatedAt($date);
        $userQuestionnaire->setUpdatedBy($actor);

        $errors = $this->validate($userQuestionnaire);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $userQuestionnaire));
        }

        $this->entityManager->persist($userQuestionnaire);

        if (true === $flush) {
            $this->entityManager->flush();

            if (true === $dispatch) {
                $event = new UserLastActivityUpdate($userQuestionnaire->getUser());
                $this->eventDispatcher->dispatch($event, UserLastActivityUpdate::NAME);
            }
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
        return $this->validator->validate($userQuestionnaire, null, ['system']);
    }
}
