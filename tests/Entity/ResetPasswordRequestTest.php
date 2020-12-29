<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\ResetPasswordRequest;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;

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
        $this->assertEquals(null, $resetPasswordRequest->getId());
    }

    public function testGetUser(): void
    {
        $user = new User();
        $expiresAt = new DateTimeImmutable();
        $selector = 'test selector';
        $hashedToken = 'test hashed token';
        $resetPasswordRequest = new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
        $this->assertEquals($user, $resetPasswordRequest->getUser());
    }
}
