<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\ResetPasswordRequest;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;

class ResetPasswordRequestTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $user = new User();
        $expiresAt = new DateTimeImmutable();
        $selector = 'test selector';
        $hashedToken = 'test hashed token';
        $resetPasswordRequest = new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
        $this->assertInstanceOf(ResetPasswordRequest::class, $resetPasswordRequest);
    }

    public function testGetId()
    {
        $user = new User();
        $expiresAt = new DateTimeImmutable();
        $selector = 'test selector';
        $hashedToken = 'test hashed token';
        $resetPasswordRequest = new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
        $this->assertEquals(null, $resetPasswordRequest->getId());
    }

    public function testGetUser()
    {
        $user = new User();
        $expiresAt = new DateTimeImmutable();
        $selector = 'test selector';
        $hashedToken = 'test hashed token';
        $resetPasswordRequest = new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
        $this->assertEquals($user, $resetPasswordRequest->getUser());
    }
}
