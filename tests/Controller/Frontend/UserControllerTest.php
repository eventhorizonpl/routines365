<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Faker\UserFaker;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class UserControllerTest extends AbstractUiTestCase
{
    public function testChangePassword(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();

        $crawler = $this->client->request('GET', '/settings/change-password');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Change password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Old password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("New password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Repeat password")')->count() > 0
        );

        $crawler = $this->client->submitForm('Change password');

        $this->assertResponseStatusCodeSame(422);
        $this->assertTrue(
            $crawler->filter('span:contains("Please enter a password")')->count() > 0
        );

        $password = 'test password';
        $crawler = $this->client->submitForm('Change password', [
            'change_password_form[oldPassword]' => $password,
            'change_password_form[plainPassword][first]' => $password,
            'change_password_form[plainPassword][second]' => $password,
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Old password is not correct!")')->count() > 0
        );

        $password = 'test password';
        $crawler = $this->client->submitForm('Change password', [
            'change_password_form[oldPassword]' => UserFaker::CUSTOMER_PASSWORD,
            'change_password_form[plainPassword][first]' => $password,
            'change_password_form[plainPassword][second]' => $password,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Profile details")')->count() > 0
        );
    }

    public function testEnable2fa(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();

        $crawler = $this->client->request('GET', '/settings/enable-2fa');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Enable 2FA")')->count() > 0
        );

        $this->assertNull($user->getGoogleAuthenticatorSecret());
        $this->entityManager->refresh($user);
        $this->assertTrue(null !== $user->getGoogleAuthenticatorSecret());
    }

    public function testDisable2fa(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();

        $crawler = $this->client->request('GET', '/settings/enable-2fa');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Enable 2FA")')->count() > 0
        );

        $this->assertNull($user->getGoogleAuthenticatorSecret());
        $this->entityManager->refresh($user);
        $this->assertTrue(null !== $user->getGoogleAuthenticatorSecret());

        $crawler = $this->client->request('GET', '/settings/disable-2fa');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Profile details")')->count() > 0
        );

        $this->assertTrue(null !== $user->getGoogleAuthenticatorSecret());
        $this->entityManager->refresh($user);
        $this->assertNull($user->getGoogleAuthenticatorSecret());
    }
}
