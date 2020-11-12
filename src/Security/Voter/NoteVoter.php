<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Note;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class NoteVoter extends Voter
{
    public const DELETE = 'delete';
    public const EDIT = 'edit';
    public const VIEW = 'view';

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, [self::DELETE, self::EDIT, self::VIEW])
            && $subject instanceof Note;
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

    private function canDelete(Note $note, User $user): bool
    {
        return $user === $note->getUser();
    }

    private function canEdit(Note $note, User $user): bool
    {
        return $user === $note->getUser();
    }

    private function canView(Note $note, User $user): bool
    {
        if (null !== $note->getDeletedAt()) {
            return false;
        }

        return $user === $note->getUser();
    }
}
