<?php

declare(strict_types=1);

namespace App\Tests\Controller\Security;

use App\Faker\PromotionFaker;
use App\Tests\AbstractUiTestCase;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

/**
 * @internal
 */
final class RegistrationControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;
    /**
     * @inject
     */
    private ?ResetPasswordHelperInterface $resetPasswordHelper;
    /**
     * @inject
     */
    private ?VerifyEmailHelperInterface $verifyEmailHelper;

    protected function tearDown(): void
    {
        $this->promotionFaker = null;
        $this->resetPasswordHelper = null;
        $this->verifyEmailHelper = null
        ;

        parent::tearDown();
    }

    public function testRequest(): void
    {
        $this->purge();
        $promotion = $this->promotionFaker->createPromotionPersisted();
        $user = $this->createRegular();

        $crawler = $this->client->request('GET', '/register?referrer_code='.$user->getReferrerCode().'&promotion_code='.$promotion->getCode());

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Register")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Repeat password")')->count() > 0
        );

        $crawler = $this->client->submitForm('Register');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('span:contains("Please enter a password")')->count() > 0
        );

        $crawler = $this->client->submitForm('Register', [
            'registration_form[email]' => 'test@example.org',
            'registration_form[plainPassword][first]' => 'password',
            'registration_form[plainPassword][second]' => 'password',
            'registration_form[agree]' => true,
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('p:contains("You do not have any routines!")')->count() > 0
        );
    }

    public function testVerifyUserEmail(): void
    {
        $this->purge();
        $user = $this->createRegular();
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'security_verify_email',
            (string) $user->getId(),
            $user->getEmail()
        );
        $url = str_replace('https://routines365.com', '', $signatureComponents->getSignedUrl());

        $crawler = $this->client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }

    public function testVerifyUserEmailLogged(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'security_verify_email',
            (string) $user->getId(),
            $user->getEmail()
        );
        $url = str_replace('https://routines365.com', '', $signatureComponents->getSignedUrl());

        $crawler = $this->client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }
}
