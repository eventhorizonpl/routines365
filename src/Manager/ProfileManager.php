<?php

namespace App\Manager;

use App\Entity\Profile;
use App\Exception\ManagerException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProfileManager
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

    public function bulkSave(array $profiles, string $actor, int $saveEvery = 50): self
    {
        $i = 1;
        foreach ($profiles as $profile) {
            $this->save($profile, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Profile $profile): self
    {
        $this->entityManager->remove($profile);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Profile $profile, string $actor, bool $flush = true): self
    {
        $date = new DateTime();
        if (null === $profile->getId()) {
            $profile->setCreatedAt($date);
            $profile->setCreatedBy($actor);
        }
        $profile->setUpdatedAt($date);
        $profile->setUpdatedBy($actor);

        $errors = $this->validate($profile);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$profile);
        }

        $this->entityManager->persist($profile);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Profile $profile, string $actor): self
    {
        $date = new DateTime();
        $profile->setDeletedAt($date);
        $profile->setDeletedBy($actor);

        $this->entityManager->persist($profile);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Profile $profile): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($profile);

        return $errors;
    }
}
