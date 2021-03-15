<?php

declare(strict_types=1);

namespace App\Tests\Security;

use App\Faker\UserFaker;
use App\Security\TokenAuthenticator;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * @internal
 * @coversNothing
 */
final class TokenAuthenticatorTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?TokenAuthenticator $tokenAuthenticator;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->tokenAuthenticator = null;
        $this->userFaker = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $tokenAuthenticator = new TokenAuthenticator($this->entityManager);

        $this->assertInstanceOf(TokenAuthenticator::class, $tokenAuthenticator);
    }

    public function testSupports(): void
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $request->headers = new ParameterBag();
        $this->assertFalse($this->tokenAuthenticator->supports($request));

        $request->headers = new ParameterBag(['X-AUTH-TOKEN' => 'X-AUTH-TOKEN']);
        $this->assertTrue($this->tokenAuthenticator->supports($request));
    }

    public function testGetCredentials(): void
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $token = 'X-AUTH-TOKEN'.uniqid();
        $request->headers = new ParameterBag(['X-AUTH-TOKEN' => $token]);
        $credentials = $this->tokenAuthenticator->getCredentials($request);
        $this->assertSame($token, $credentials);
        $this->assertIsString($credentials);
    }

    public function testCheckCredentials(): void
    {
        $user = $this->userFaker->createRichUserPersisted();
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $token = 'X-AUTH-TOKEN'.uniqid();
        $request->headers = new ParameterBag(['X-AUTH-TOKEN' => $token]);
        $credentials = $this->tokenAuthenticator->getCredentials($request);

        $this->assertTrue($this->tokenAuthenticator->checkCredentials($credentials, $user));
    }

    public function testSupportsRememberMe(): void
    {
        $this->assertFalse($this->tokenAuthenticator->supportsRememberMe());
        $this->assertIsBool($this->tokenAuthenticator->supportsRememberMe());
    }
}
