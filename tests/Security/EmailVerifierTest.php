<?php

declare(strict_types=1);

namespace App\Tests\Security;

use App\Faker\UserFaker;
use App\Manager\UserManager;
use App\Security\EmailVerifier;
use App\Service\EmailService;
use App\Tests\AbstractDoctrineTestCase;
use Symfony\Component\HttpFoundation\Request;
use SymfonyCasts\Bundle\VerifyEmail\Exception\InvalidSignatureException;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class EmailVerifierTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?EmailVerifier $emailVerifier;
    /**
     * @inject
     */
    private ?UserFaker $userFaker;
    /**
     * @inject
     */
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?VerifyEmailHelperInterface $verifyEmailHelper;

    protected function tearDown(): void
    {
        unset(
            $this->emailVerifier,
            $this->userFaker,
            $this->userManager,
            $this->verifyEmailHelper
        );

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $emailService = $this->getMockBuilder(EmailService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $emailVerifier = new EmailVerifier($emailService, $this->userManager, $this->verifyEmailHelper);

        $this->assertInstanceOf(EmailVerifier::class, $emailVerifier);
    }

    public function testSendEmailConfirmation(): void
    {
        $user = $this->userFaker->createRichUserPersisted();
        $user->setEmail('test@example.org');
        $this->assertNull($this->emailVerifier->sendEmailConfirmation($user));
    }

    public function testHandleEmailConfirmationException(): void
    {
        $this->expectException(InvalidSignatureException::class);
        $user = $this->userFaker->createRichUserPersisted();
        $user->setEmail('test@example.org');
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request->method('getUri')
             ->willReturn('test');

        $this->emailVerifier->handleEmailConfirmation($request, $user);
    }
}
