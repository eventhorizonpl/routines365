<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class StaticPageControllerTest extends AbstractUiTestCase
{
    public function testAbout(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/about');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h2:contains("We help. You achieve.")')->count() > 0
        );
    }

    public function testChangelog(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/changelog');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Changelog")')->count() > 0
        );
    }

    public function testContact(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/contact');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Contact")')->count() > 0
        );
    }

    public function testFaq(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/faq');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("FAQ")')->count() > 0
        );
    }

    public function testHowTo(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("How-to")')->count() > 0
        );
    }

    public function testHowToBasicConfiguration(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/basic-configuration');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Basic configuration")')->count() > 0
        );
    }

    public function testHowToCompletingRoutines(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/completing-routines');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Completing routines")')->count() > 0
        );
    }

    public function testHowToGoals(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/goals');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Goals")')->count() > 0
        );
    }

    public function testHowToNotes(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/notes');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Notes")')->count() > 0
        );
    }

    public function testHowToProjects(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/projects');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Projects")')->count() > 0
        );
    }

    public function testHowToReminders(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/reminders');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Reminders")')->count() > 0
        );
    }

    public function testHowToRewards(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/rewards');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Rewards")')->count() > 0
        );
    }

    public function testHowToRoutines(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/routines');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Routines")')->count() > 0
        );
    }

    public function testPrivacyPolicy(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/privacy-policy');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Privacy Policy")')->count() > 0
        );
    }

    public function testTermsAndConditions(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/terms-and-conditions');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('h1:contains("Terms and Conditions")')->count() > 0
        );
    }

    public function testTheme(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/theme');

        $this->assertResponseIsSuccessful();
    }
}
