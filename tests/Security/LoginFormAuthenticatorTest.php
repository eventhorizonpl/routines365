<?php

declare(strict_types=1);

namespace App\Tests\Security;

use App\Faker\UserFaker;
use App\Security\LoginFormAuthenticator;
use App\Service\UserService;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class LoginFormAuthenticatorTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?CsrfTokenManagerInterface $csrfTokenManager;
    /**
     * @inject
     */
    private ?LoginFormAuthenticator $loginFormAuthenticator;
    /**
     * @inject
     */
    private ?UrlGeneratorInterface $urlGenerator;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserPasswordEncoderInterface $userPasswordEncoder;
    /**
     * @inject
     */
    private ?UserService $userService;
    /**
     * @inject
     */
    private ?VerifyEmailHelperInterface $verifyEmailHelper;

    protected function tearDown(): void
    {
        unset(
            $this->csrfTokenManager,
            $this->loginFormAuthenticator,
            $this->urlGenerator,
            $this->userFaker,
            $this->userPasswordEncoder,
            $this->userService,
            $this->verifyEmailHelper
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $loginFormAuthenticator = new LoginFormAuthenticator(
            $this->csrfTokenManager,
            $this->entityManager,
            $this->urlGenerator,
            $this->userPasswordEncoder,
            $this->userService
        );

        $this->assertInstanceOf(LoginFormAuthenticator::class, $loginFormAuthenticator);
    }

    public function testSupports(): void
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request->method('isMethod')
             ->willReturn('POST');

        $request->attributes = new ParameterBag();
        $this->assertFalse($this->loginFormAuthenticator->supports($request));

        $request->attributes = new ParameterBag(['_route' => 'security_login']);
        $this->assertTrue($this->loginFormAuthenticator->supports($request));
    }

    public function testGetCredentials(): void
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request->request = new ParameterBag([
            'email' => 'test email',
            'password' => 'test password',
            '_csrf_token' => 'test _csrf_token',
        ]);

        $credentials = $this->loginFormAuthenticator->getCredentials($request);

        $this->assertIsArray($credentials);
    }

    public function testGetPassword(): void
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $password = 'test password';
        $request->request = new ParameterBag([
            'email' => 'test email',
            'password' => $password,
            '_csrf_token' => 'test _csrf_token',
        ]);

        $credentials = $this->loginFormAuthenticator->getCredentials($request);

        $this->assertIsArray($credentials);
        $this->assertEquals($password, $this->loginFormAuthenticator->getPassword($credentials));
    }
}
