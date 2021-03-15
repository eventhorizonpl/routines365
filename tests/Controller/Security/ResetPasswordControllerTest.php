<?php

declare(strict_types=1);

namespace App\Tests\Controller\Security;

use App\Tests\AbstractUiTestCase;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

/**
 * @internal
 * @coversNothing
 */
final class ResetPasswordControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?ResetPasswordHelperInterface $resetPasswordHelper;

    protected function tearDown(): void
    {
        $this->resetPasswordHelper = null;

        parent::tearDown();
    }

    public function testRequest(): void
    {
        $this->purge();
        $user = $this->createRegular();

        $crawler = $this->client->request('GET', '/reset-password');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Reset your password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Email")')->count() > 0
        );

        $crawler = $this->client->submitForm('Send password reset email');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('span:contains("Please enter your email")')->count() > 0
        );

        $crawler = $this->client->submitForm('Send password reset email', [
            'reset_password_request_form[email]' => $user->getEmail(),
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Password reset email sent")')->count() > 0
        );
    }

    public function testCheckEmail(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/reset-password/check-email');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Reset your password")')->count() > 0
        );
    }

    public function testReset(): void
    {
        $this->purge();
        $user = $this->createRegular();

        $resetToken = $this->resetPasswordHelper->generateResetToken($user);

        $crawler = $this->client->request('GET', '/reset-password/reset/'.$resetToken->getToken());

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Reset your password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("New password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Repeat password")')->count() > 0
        );

        $password = 'password';
        $crawler = $this->client->submitForm('Reset password', [
            'change_password_form[plainPassword][first]' => $password,
            'change_password_form[plainPassword][second]' => $password.'123',
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('span:contains("The password fields must match.")')->count() > 0
        );

        $crawler = $this->client->submitForm('Reset password', [
            'change_password_form[plainPassword][first]' => $password,
            'change_password_form[plainPassword][second]' => $password,
        ]);

        $this->assertTrue(
            $crawler->filter('h2:contains("We help. You achieve.")')->count() > 0
        );
    }

    public function testReset2(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/reset-password/reset/wrong-token');

        $this->assertTrue(
            $crawler->filter('div:contains("There was a problem validating your reset request - The reset password link is invalid. Please try to reset your password again.")')->count() > 0
        );
    }

    public function testResetException(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/reset-password/reset/');
        $this->assertSame(404, $this->client->getResponse()->getStatusCode());
    }
}
