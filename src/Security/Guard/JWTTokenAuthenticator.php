<?php

declare(strict_types=1);

namespace App\Security\Guard;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Guard\JWTTokenAuthenticator as BaseJWTTokenAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JWTTokenAuthenticator extends BaseJWTTokenAuthenticator
{
    public function getUser($preAuthToken, UserProviderInterface $userProvider): ?User
    {
        $user = parent::getUser($preAuthToken, $userProvider);

        if (false === $user->getIsEnabled()) {
            throw new CustomUserMessageAccountStatusException('Account disabled.');
        }

        return $user;
    }
}
