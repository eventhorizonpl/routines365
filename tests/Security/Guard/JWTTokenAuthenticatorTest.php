<?php

declare(strict_types=1);

namespace App\Tests\Security\Guard;

use App\Entity\{Note, User};
use App\Faker\UserFaker;
use App\Security\Guard\JWTTokenAuthenticator;
use App\Tests\AbstractDoctrineTestCase;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\PreAuthenticationJWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @internal
 */
final class JWTTokenAuthenticatorTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?JWTManager $jwtManager;
    /**
     * @inject
     */
    private ?JWTTokenAuthenticator $jwtTokenAuthenticator;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserProviderInterface $userProvider;

    protected function tearDown(): void
    {
        $this->jwtManager = null;
        $this->jwtTokenAuthenticator = null;
        $this->userFaker = null;
        $this->userProvider = null;

        parent::tearDown();
    }

    public function testGetUser(): void
    {
        $this->purge();
        $user = $this->userFaker->createUserPersisted(null, true);
        $token = $this->jwtManager->create($user);

        $this->assertIsString($token);
        $preAuthenticationJWTUserToken = new PreAuthenticationJWTUserToken($token);
        $preAuthenticationJWTUserToken->setPayload(['username' => $user->getUsername()]);

        $user2 = $this->jwtTokenAuthenticator->getUser($preAuthenticationJWTUserToken, $this->userProvider);
        $this->assertInstanceOf(User::class, $user2);
    }

    public function testGetUserException(): void
    {
        $this->expectException(CustomUserMessageAccountStatusException::class);
        $this->purge();
        $user = $this->userFaker->createUserPersisted(null, false);
        $token = $this->jwtManager->create($user);

        $this->assertIsString($token);
        $preAuthenticationJWTUserToken = new PreAuthenticationJWTUserToken($token);
        $preAuthenticationJWTUserToken->setPayload(['username' => $user->getUsername()]);

        $user2 = $this->jwtTokenAuthenticator->getUser($preAuthenticationJWTUserToken, $this->userProvider);
    }
}
