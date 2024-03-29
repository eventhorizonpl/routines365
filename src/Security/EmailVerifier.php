<?php

declare(strict_types=1);

namespace App\Security;

use App\Manager\UserManager;
use App\Service\EmailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    public function __construct(
        private EmailService $emailService,
        private UserManager $userManager,
        private VerifyEmailHelperInterface $verifyEmailHelper
    ) {
    }

    public function sendEmailConfirmation(UserInterface $user): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'security_verify_email',
            (string) $user->getId(),
            $user->getEmail()
        );

        $this->emailService->sendConfirmation(
            $user->getEmail(),
            'R365: Please confirm your email',
            [
                'expires_at' => $signatureComponents->getExpiresAt(),
                'signed_url' => $signatureComponents->getSignedUrl(),
            ]
        );
    }

    public function handleEmailConfirmation(Request $request, UserInterface $user): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), (string) $user->getId(), $user->getEmail());

        $user->setIsVerified(true);

        $this->userManager->save($user);
    }
}
