<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Achievement;
use App\Faker\AchievementFaker;
use App\Manager\AchievementManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class AchievementControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?AchievementFaker $achievementFaker;
    /**
     * @inject
     */
    private ?AchievementManager $achievementManager;

    protected function tearDown(): void
    {
        $this->achievementFaker = null;
        $this->achievementManager = null
        ;

        parent::tearDown();
    }

    public function createAchievement(): Achievement
    {
        return $this->achievementFaker->createAchievementPersisted();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $achievement = $this->createAchievement();

        $crawler = $this->client->request('GET', '/admin/achievement/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Achievements")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Level")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Requirement")')->count() > 0
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
            $crawler->filter('td:contains("'.$achievement->getUuid().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();

        $crawler = $this->client->request(
            'GET',
            '/admin/achievement/new'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create an achievement")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Level")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Requirement")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $name = 'test name';
        $crawler = $this->client->submitForm('Save', [
            'achievement[name]' => $name,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $achievement = $this->createAchievement();

        $crawler = $this->client->request(
            'GET',
            '/admin/achievement/'.$achievement->getUuid()
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
            $crawler->filter('td:contains("'.$achievement->getUuid().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $achievement = $this->createAchievement();

        $crawler = $this->client->request(
            'GET',
            '/admin/achievement/'.$achievement->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit an achievement")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Level")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Requirement")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );

        $name = 'test name';
        $crawler = $this->client->submitForm('Update', [
            'achievement[name]' => $name,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $achievement = $this->createAchievement();

        $crawler = $this->client->request(
            'GET',
            '/admin/achievement/'.$achievement->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Achievements")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $achievement = $this->createAchievement();
        $this->achievementManager->softDelete($achievement, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/achievement/'.$achievement->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Achievements")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$achievement->getUuid().'")')->count() > 0
        );
    }
}
