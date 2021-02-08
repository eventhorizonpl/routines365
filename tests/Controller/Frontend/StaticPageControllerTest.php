<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

final class StaticPageControllerTest extends AbstractUiTestCase
{
    public function testAbout(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/about');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'We help. You achieve.');
    }

    public function testChangelog(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/changelog');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Changelog');
    }

    public function testContact(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/contact');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Contact');
    }

    public function testFaq(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/faq');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'FAQ');
    }

    public function testHowTo(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'How-to');
    }

    public function testHowToBasicConfiguration(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/basic-configuration');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Basic configuration');
    }

    public function testHowToCompletingRoutines(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/completing-routines');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', ' Completing routines');
    }

    public function testHowToGoals(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/goals');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Goals');
    }

    public function testHowToNotes(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/notes');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Notes');
    }

    public function testHowToProjects(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/projects');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Projects');
    }

    public function testHowToReminders(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/reminders');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Reminders');
    }

    public function testHowToRewards(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/rewards');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Rewards');
    }

    public function testHowToRoutines(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/how-to/routines');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Routines');
    }

    public function testPrivacyPolicy(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/privacy-policy');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Privacy Policy');
    }

    public function testTermsAndConditions(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/terms-and-conditions');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Terms and Conditions');
    }

    public function testTheme(): void
    {
        $this->purge();

        $crawler = $this->client->request('GET', '/page/theme');

        $this->assertResponseIsSuccessful();
    }
}
