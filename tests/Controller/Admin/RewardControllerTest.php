<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Reward;
use App\Manager\RewardManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class RewardControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?RewardManager $rewardManager;

    protected function tearDown(): void
    {
        $this->rewardManager = null;

        parent::tearDown();
    }

    public function createReward(): Reward
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getRewards()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $reward = $this->createReward();

        $crawler = $this->client->request('GET', '/admin/reward/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Rewards")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is awarded")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Number of completions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Required number of completions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Deleted at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Updated at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reward->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reward->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $reward = $this->createReward();

        $crawler = $this->client->request(
            'GET',
            '/admin/reward/'.$reward->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Relations")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reward->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $reward = $this->createReward();
        $this->rewardManager->softDelete($reward, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/reward/'.$reward->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Rewards")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$reward->getUuid().'")')->count() > 0
        );
    }
}
