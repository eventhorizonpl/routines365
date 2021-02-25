<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\Promotion;
use App\Faker\PromotionFaker;
use App\Tests\AbstractUiTestCase;

final class UserKytControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;

    protected function tearDown(): void
    {
        unset(
            $this->promotionFaker,
        );

        parent::tearDown();
    }

    public function testBasicConfiguration(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/know-your-tools/basic-configuration');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Basic configuration');
    }

    public function testBasicConfigurationFinish(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $crawler = $this->client->request('GET', '/know-your-tools/basic-configuration-finish');
        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We added a small reward to your account.")')->count() > 0
        );
    }

    public function testCompletingRoutines(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/know-your-tools/completing-routines');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Completing routines');
    }

    public function testCompletingRoutinesFinish(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $crawler = $this->client->request('GET', '/know-your-tools/completing-routines-finish');
        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We added a small reward to your account.")')->count() > 0
        );
    }

    public function testGoals(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/know-your-tools/goals');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Goals');
    }

    public function testGoalsFinish(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $crawler = $this->client->request('GET', '/know-your-tools/goals-finish');
        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We added a small reward to your account.")')->count() > 0
        );
    }

    public function testNotes(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/know-your-tools/notes');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Notes');
    }

    public function testNotesFinish(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $crawler = $this->client->request('GET', '/know-your-tools/notes-finish');
        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We added a small reward to your account.")')->count() > 0
        );
    }

    public function testProjects(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/know-your-tools/projects');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Projects');
    }

    public function testProjectsFinish(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $crawler = $this->client->request('GET', '/know-your-tools/projects-finish');
        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We added a small reward to your account.")')->count() > 0
        );
    }

    public function testReminders(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/know-your-tools/reminders');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Reminders');
    }

    public function testRemindersFinish(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $crawler = $this->client->request('GET', '/know-your-tools/reminders-finish');
        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We added a small reward to your account.")')->count() > 0
        );
    }

    public function testRewards(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/know-your-tools/rewards');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Rewards');
    }

    public function testRewardsFinish(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $crawler = $this->client->request('GET', '/know-your-tools/rewards-finish');
        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We added a small reward to your account.")')->count() > 0
        );
    }

    public function testRoutines(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/know-your-tools/routines');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Routines');
    }

    public function testRoutinesFinish(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $crawler = $this->client->request('GET', '/know-your-tools/routines-finish');
        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We added a small reward to your account.")')->count() > 0
        );
    }

    public function testStart(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/know-your-tools/start');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Know your tools');
    }
}
