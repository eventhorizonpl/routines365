<?php

namespace App\Manager;

use App\Entity\Profile;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use League\ISO3166\Exception\OutOfBoundsException;
use League\ISO3166\ISO3166;
use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
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

    public function bulkSave(array $profiles, string $actor, int $saveEvery = 100): self
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
        $date = new DateTimeImmutable();
        if (null === $profile->getId()) {
            $profile->setCreatedAt($date);
            $profile->setCreatedBy($actor);
        }
        $profile->setUpdatedAt($date);
        $profile->setUpdatedBy($actor);

        if (null !== $profile->getPhone()) {
            $descriptionForNumber = PhoneNumberOfflineGeocoder::getInstance()
                ->getDescriptionForNumber($profile->getPhone(), 'en');
            try {
                $country = (new ISO3166())->name($descriptionForNumber);
                $profile->setCountry($country['alpha2']);
            } catch (OutOfBoundsException $e) {
            }
        }

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
        $date = new DateTimeImmutable();
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
