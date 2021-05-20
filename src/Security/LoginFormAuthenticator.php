<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Enum\{UserRoleEnum, UserTypeEnum};
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{RedirectResponse, Request};
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\{CustomUserMessageAuthenticationException, InvalidCsrfTokenException};
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\{UserInterface, UserProviderInterface};
use Symfony\Component\Security\Csrf\{CsrfToken, CsrfTokenManagerInterface};
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'security_login';

    public function __construct(
        private CsrfTokenManagerInterface $csrfTokenManager,
        private EntityManagerInterface $entityManager,
        private UrlGeneratorInterface $urlGenerator,
        private UserPasswordEncoderInterface $passwordEncoder,
        private UserService $userService
    ) {
    }

    public function supports(Request $request): bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request): array
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        if (null !== $request->getSession()) {
            $request->getSession()->set(
                Security::LAST_USERNAME,
                $credentials['email']
            );
        }

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): User
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneByEmail($credentials['email']);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     *
     * @param mixed $credentials
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): RedirectResponse
    {
        if (UserTypeEnum::LEAD === $token->getUser()->getType()) {
            $this->userService->changeTypeToProspect($token->getUser());
        }

        $this->userService->onAuthenticationSuccess($token->getUser());

        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        if ((UserTypeEnum::STAFF === $token->getUser()->getType()) || (\in_array(UserRoleEnum::ROLE_ADMIN, $token->getRoleNames(), true))) {
            return new RedirectResponse($this->urlGenerator->generate('admin_workspace'));
        }
        if (\in_array(UserRoleEnum::ROLE_USER, $token->getRoleNames(), true)) {
            return new RedirectResponse($this->urlGenerator->generate('frontend_routine_index'));
        }

        return new RedirectResponse($this->urlGenerator->generate('frontend_home'));
    }

    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
