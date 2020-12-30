<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Project;
use App\Exception\ManagerException;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectManager
{
    private EntityManagerInterface $entityManager;
    private GoalManager $goalManager;
    private ValidatorInterface $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        GoalManager $goalManager,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->goalManager = $goalManager;
        $this->validator = $validator;
    }

    public function bulkSave(array $projects, string $actor = null, int $saveEvery = 200): self
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);
        $i = 1;
        foreach ($projects as $project) {
            $this->save($project, $actor, false);
            if ($i >= $saveEvery) {
                $this->entityManager->flush();
                $i = 1;
            }
            ++$i;
        }

        $this->entityManager->flush();

        return $this;
    }

    public function delete(Project $project): self
    {
        $this->entityManager->remove($project);
        $this->entityManager->flush();

        return $this;
    }

    public function save(Project $project, string $actor = null, bool $flush = true): self
    {
        if (null === $actor) {
            $actor = (string) $project->getUser();
        }

        $date = new DateTimeImmutable();
        if (null === $project->getId()) {
            $project->setCreatedAt($date);
            $project->setCreatedBy($actor);
        }
        $project->setUpdatedAt($date);
        $project->setUpdatedBy($actor);

        if ((false === $project->getIsCompleted()) &&
            (null !== $project->getCompletedAt())
        ) {
            $project->setCompletedAt(null);
        } elseif ((true === $project->getIsCompleted()) &&
            (null === $project->getCompletedAt())
        ) {
            $project->setCompletedAt($date);
        }

        $errors = $this->validate($project);
        if (0 !== count($errors)) {
            throw new ManagerException((string) $errors.' '.$project);
        }

        $this->entityManager->persist($project);

        if (true === $flush) {
            $this->entityManager->flush();
        }

        return $this;
    }

    public function softDelete(Project $project, string $actor): self
    {
        $date = new DateTimeImmutable();
        $project->setDeletedAt($date);
        $project->setDeletedBy($actor);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        foreach ($project->getGoals() as $goal) {
            $this->goalManager->softDelete($goal, $actor);
        }

        return $this;
    }

    public function undelete(Project $project): self
    {
        $project->setDeletedAt(null);
        $project->setDeletedBy(null);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $this;
    }

    public function validate(Project $project): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($project, null, ['system']);

        return $errors;
    }
}
