<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Retention;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RetentionManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $retentions, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($retentions as $retention) {
            $this->save($retention, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Retention $retention): self
    {
        $this->entityManager->remove($retention);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Retention $retention, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $retention->getId()) {
            $retention->setCreatedAt($date);
        }
        $retention->setUpdatedAt($date);

        $errors = $this->validate($retention);
        if (0 !== \count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $retention));
        }

        $this->entityManager->persist($retention);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Retention $retention): self
    {
        $date = new DateTimeImmutable();
        $retention->setDeletedAt($date);

        $this->entityManager->persist($retention);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Retention $retention): self
    {
        $retention->setDeletedAt(null);

        $this->entityManager->persist($retention);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Retention $retention): ConstraintViolationListInterface
    {
        return $this->validator->validate($retention, null, ['system']);
    }
}
