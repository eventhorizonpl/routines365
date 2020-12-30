<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\AccountOperation;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AccountOperationManager
{
    private AccountManager $accountManager;
    private EntityManagerInterface $entityManager;
    private ValidatorInterface $validator;

    public function __construct(
        AccountManager $accountManager,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->accountManager = $accountManager;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function bulkSave(array $accountOperations, string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($accountOperations as $accountOperation) {
            $this->save($accountOperation, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(AccountOperation $accountOperation): self
    {
        $this->entityManager->remove($accountOperation);
        $this->entityManager->flush();

        return $this;
    }

    public function save(AccountOperation $accountOperation, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $accountOperation->getAccount()->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $accountOperation->getId()) {
            $accountOperation->setCreatedAt($date);
            $accountOperation->setCreatedBy($actor);
        }
        $accountOperation->setUpdatedAt($date);
        $accountOperation->setUpdatedBy($actor);

        $errors = $this->validate($accountOperation);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$accountOperation);
        }

        $account = $accountOperation->getAccount();
        if (AccountOperation::TYPE_DEPOSIT === $accountOperation->getType()) {
            $account->depositEmailNotifications($accountOperation->getEmailNotifications());
            $account->depositSmsNotifications($accountOperation->getSmsNotifications());
        } elseif (AccountOperation::TYPE_WITHDRAW === $accountOperation->getType()) {
            $account->withdrawEmailNotifications($accountOperation->getEmailNotifications());
            $account->withdrawSmsNotifications($accountOperation->getSmsNotifications());
        }

        $this->entityManager->persist($accountOperation);
        $this->accountManager->save($account, $actor, false);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(AccountOperation $accountOperation, string $actor): self
    {
        $date = new DateTimeImmutable();
        $accountOperation->setDeletedAt($date);
        $accountOperation->setDeletedBy($actor);

        $this->entityManager->persist($accountOperation);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(AccountOperation $accountOperation): self
    {
        $accountOperation->setDeletedAt(null);
        $accountOperation->setDeletedBy(null);

        $this->entityManager->persist($accountOperation);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(AccountOperation $accountOperation): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($accountOperation, null, ['system']);

        return $errors;
    }
}
