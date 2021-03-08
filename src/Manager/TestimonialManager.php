<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Testimonial;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestimonialManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
    }

    public function bulkSave(array $testimonials, string $actor, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($testimonials as $testimonial) {
            $this->save($testimonial, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Testimonial $testimonial): self
    {
        $this->entityManager->remove($testimonial);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Testimonial $testimonial, string $actor, bool $flush = true): self
    {
        $date = new DateTimeImmutable();
        if (null === $testimonial->getId()) {
            $testimonial->setCreatedAt($date);
            $testimonial->setCreatedBy($actor);
        }
        $testimonial->setUpdatedAt($date);
        $testimonial->setUpdatedBy($actor);

        $errors = $this->validate($testimonial);
        if (0 !== count($errors)) {
            throw new ManagerException(sprintf('%s %s', (string) $errors, $testimonial));
        }

        $this->entityManager->persist($testimonial);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Testimonial $testimonial, string $actor): self
    {
        $date = new DateTimeImmutable();
        $testimonial->setDeletedAt($date);
        $testimonial->setDeletedBy($actor);

        $this->entityManager->persist($testimonial);
        $this->entityManager->flush();

        return $this;
    }

    public function undelete(Testimonial $testimonial): self
    {
        $testimonial->setDeletedAt(null);
        $testimonial->setDeletedBy(null);

        $this->entityManager->persist($testimonial);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Testimonial $testimonial): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($testimonial, null, ['system']);

        return $errors;
    }
}
