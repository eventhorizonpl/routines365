<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Reward;
use App\Event\UserLastActivityUpdate;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RewardManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $rewards, string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($rewards as $reward) {
            $this->save($reward, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Reward $reward): self
    {
        $this->entityManager->remove($reward);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Reward $reward, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $reward->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $reward->getId()) {
            $reward->setCreatedAt($date);
            $reward->setCreatedBy($actor);
        }
        $reward->setUpdatedAt($date);
        $reward->setUpdatedBy($actor);

        if ($reward->getNumberOfCompletions() >= $reward->getRequiredNumberOfCompletions()) {
            $reward->setIsAwarded(true);
        } else {
            $reward->setIsAwarded(false);
        }

        $errors = $this->validate($reward);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $reward));
        }

        $this->entityManager->persist($reward);

        if (true === $flush) {
            $this->entityManager->flush();

            $event = new UserLastActivityUpdate($reward->getUser());
            $this->eventDispatcher->dispatch($event, UserLastActivityUpdate::NAME);
        }

        return $this;
    }

    public function softDelete(Reward $reward, string $actor): self
    {
        $date = new DateTimeImmutable();
        $reward->setDeletedAt($date);
        $reward->setDeletedBy($actor);

        $this->entityManager->persist($reward);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Reward $reward): self
    {
        $reward->setDeletedAt(null);
        $reward->setDeletedBy(null);

        $this->entityManager->persist($reward);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Reward $reward): ConstraintViolationListInterface
    {
        return $this->validator->validate($reward, null, ['system']);
    }
}
