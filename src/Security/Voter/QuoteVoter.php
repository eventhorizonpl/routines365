<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Quote;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class QuoteVoter extends Voter
{
    public const SEND = 'send';

    protected function supports($attribute, $subject): bool
    {
        return \in_array($attribute, [self::SEND], true)
            && $subject instanceof Quote;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::SEND:
                return $this->canSend($subject, $user);
        }

        return false;
    }

    private function canSend(Quote $quote, User $user): bool
    {
        if ((null === $quote->getDeletedAt()) && (true === $quote->getIsVisible())) {
            return true;
        }

        return false;
    }
}
