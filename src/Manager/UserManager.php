<?php

namespace App\Manager;

use App\Entity\User;
use App\Exception\ManagerException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private EntityManagerInterface $entityManager;
    private ProfileManager $profileManager;
    private ValidatorInterface $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProfileManager $profileManager,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->profileManager = $profileManager;
        $this->validator = $validator;
    }

    public function bulkSave(array $users, string $actor = null, int $saveEvery = 100): self
    {
        $i = 1;
        foreach ($users as $user) {
            $this->save($user, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(User $user): self
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this;
    }

    public function save(User $user, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = $user->getUuid();
        }
        $date = new DateTime();
        if (null === $user->getId()) {
            $user->setCreatedAt($date);
            $user->setCreatedBy($actor);
        }
        $user->setUpdatedAt($date);
        $user->setUpdatedBy($actor);

        $errors = $this->validate($user);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors);
        }

        $this->entityManager->persist($user);
        $this->profileManager->save($user->getProfile(), $actor, false);
        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(User $user, string $actor): self
    {
        $date = new DateTime();
        $user->setDeletedAt($date);
        $user->setDeletedBy($actor);

        $errors = $this->validate($user);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(User $user): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($user, null, ['system']);

        return $errors;
    }
}
