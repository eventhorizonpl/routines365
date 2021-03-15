<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Routine;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RoutineVoter extends Voter
{
    public const DELETE = 'delete';
    public const EDIT = 'edit';
    public const VIEW = 'view';

    protected function supports($attribute, $subject): bool
    {
        return \in_array($attribute, [self::DELETE, self::EDIT, self::VIEW], true)
            && $subject instanceof Routine;
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

    private function canDelete(Routine $routine, User $user): bool
    {
        return $user === $routine->getUser();
    }

    private function canEdit(Routine $routine, User $user): bool
    {
        return $user === $routine->getUser();
    }

    private function canView(Routine $routine, User $user): bool
    {
        if (null !== $routine->getDeletedAt()) {
            return false;
        }

        return $user === $routine->getUser();
    }
}
