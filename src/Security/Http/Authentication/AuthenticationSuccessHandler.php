<?php

declare(strict_types=1);

namespace App\Security\Http\Authentication;

use App\Manager\UserManager;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler as BaseAuthenticationSuccessHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class AuthenticationSuccessHandler extends BaseAuthenticationSuccessHandler
{
    public function __construct(
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $dispatcher,
        private UserManager $userManager,
        $cookieProviders
    ) {
        parent::__construct($jwtManager, $dispatcher, $cookieProviders);
    }

    public function handleAuthenticationSuccess(
        UserInterface $user,
        $jwt = null
    ): JWTAuthenticationSuccessResponse {
        $response = parent::handleAuthenticationSuccess($user, $jwt);

        $this->userManager->updateLastLoginAt($user);

        return $response;
    }
}
