<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Goal;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GoalVoter extends Voter
{
    public const DELETE = 'delete';
    public const EDIT = 'edit';

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, [self::DELETE, self::EDIT])
            && $subject instanceof Goal;
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
        }

        return false;
    }

    private function canDelete(Goal $goal, User $user): bool
    {
        return $user === $goal->getUser();
    }

    private function canEdit(Goal $goal, User $user): bool
    {
        return $user === $goal->getUser();
    }
}
