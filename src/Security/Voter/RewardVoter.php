<?php

namespace App\Security\Voter;

use App\Entity\Reward;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RewardVoter extends Voter
{
    public const DELETE = 'delete';
    public const EDIT = 'edit';
    public const VIEW = 'view';

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, [self::DELETE, self::EDIT, self::VIEW])
            && $subject instanceof Reward;
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

    private function canDelete(Reward $reward, User $user): bool
    {
        return $user === $reward->getUser();
    }

    private function canEdit(Reward $reward, User $user): bool
    {
        return $user === $reward->getUser();
    }

    private function canView(Reward $reward, User $user): bool
    {
        if (null !== $reward->getDeletedAt()) {
            return false;
        }

        return $user === $reward->getUser();
    }
}
