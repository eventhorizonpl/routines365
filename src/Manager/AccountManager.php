<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Account;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AccountManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $accounts, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($accounts as $account) {
            $this->save($account, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Account $account): self
    {
        $this->entityManager->remove($account);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Account $account, string $actor, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $account->getId()) {
            $account->setCreatedAt($date);
            $account->setCreatedBy($actor);
        }
        $account->setUpdatedAt($date);
        $account->setUpdatedBy($actor);

        $errors = $this->validate($account);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $account));
        }

        $this->entityManager->persist($account);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Account $account, string $actor): self
    {
        $date = new DateTimeImmutable();
        $account->setDeletedAt($date);
        $account->setDeletedBy($actor);

        $this->entityManager->persist($account);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Account $account): self
    {
        $account->setDeletedAt(null);
        $account->setDeletedBy(null);

        $this->entityManager->persist($account);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Account $account): ConstraintViolationListInterface
    {
        return $this->validator->validate($account);
    }
}
