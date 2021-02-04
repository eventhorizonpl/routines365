<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Goal;
use App\Manager\GoalManager;
use App\Tests\AbstractUiTestCase;

final class GoalControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?GoalManager $goalManager;

    protected function tearDown(): void
    {
        unset($this->goalManager);

        parent::tearDown();
    }

    public function createGoal(): Goal
    {
        $user = $this->userFaker->createRichUserPersisted();
        $goal = $user->getGoals()->first();

        return $goal;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $goal = $this->createGoal();

        $crawler = $this->client->request('GET', '/admin/goal/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'Goals');
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
            $crawler->filter('th:contains("Is completed")')->count() > 0
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
            $crawler->filter('td:contains("'.$goal->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$goal->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $goal = $this->createGoal();

        $crawler = $this->client->request(
            'GET',
            '/admin/goal/'.$goal->getUuid()
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
            $crawler->filter('td:contains("'.$goal->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $goal = $this->createGoal();
        $this->goalManager->softDelete($goal, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/goal/'.$goal->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Goals")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$goal->getUuid().'")')->count() > 0
        );
    }
}
