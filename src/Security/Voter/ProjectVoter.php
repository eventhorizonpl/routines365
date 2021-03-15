<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Project;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProjectVoter extends Voter
{
    public const DELETE = 'delete';
    public const EDIT = 'edit';
    public const VIEW = 'view';

    protected function supports($attribute, $subject): bool
    {
        return \in_array($attribute, [self::DELETE, self::EDIT, self::VIEW], true)
            && $subject instanceof Project;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::VIEW:
                return $this->canView($subject, $user);
        }

        return false;
    }

    private function canDelete(Project $project, User $user): bool
    {
        return $user === $project->getUser();
    }

    private function canEdit(Project $project, User $user): bool
    {
        return $user === $project->getUser();
    }

    private function canView(Project $project, User $user): bool
    {
        if (null !== $project->getDeletedAt()) {
            return false;
        }

        return $user === $project->getUser();
    }
}
