<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Questionnaire;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class QuestionnaireVoter extends Voter
{
    public const COMPLETE = 'complete';

    protected function supports($attribute, $subject): bool
    {
        return \in_array($attribute, [self::COMPLETE], true)
            && $subject instanceof Questionnaire;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::COMPLETE:
                return $this->canComplete($subject, $user);
        }

        return false;
    }

    private function canComplete(Questionnaire $questionnaire, User $user): bool
    {
        if ((null !== $questionnaire->getDeletedAt())
            || (false === $questionnaire->getIsEnabled())
        ) {
            return false;
        }

        return true;
    }
}
