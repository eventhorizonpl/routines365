<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{ResetPasswordRequest, User};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;

/**
 * @internal
 * @coversNothing
 */
final class ResetPasswordRequestTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $user = new User();
        $expiresAt = new DateTimeImmutable();
        $selector = 'test selector';
        $hashedToken = 'test hashed token';
        $resetPasswordRequest = new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
        $this->assertInstanceOf(ResetPasswordRequest::class, $resetPasswordRequest);
    }

    public function testGetId(): void
    {
        $user = new User();
        $expiresAt = new DateTimeImmutable();
        $selector = 'test selector';
        $hashedToken = 'test hashed token';
        $resetPasswordRequest = new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
        $this->assertNull($resetPasswordRequest->getId());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $expiresAt = new DateTimeImmutable();
        $selector = 'test selector';
        $hashedToken = 'test hashed token';
        $resetPasswordRequest = new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
        $this->assertSame($user, $resetPasswordRequest->getUser());
    }
}
