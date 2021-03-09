<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Questionnaire;
use App\Faker\QuestionnaireFaker;
use App\Manager\QuestionnaireManager;
use App\Tests\AbstractUiTestCase;

final class QuestionnaireControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?QuestionnaireManager $questionnaireManager;

    protected function tearDown(): void
    {
        unset(
            $this->questionnaireFaker,
            $this->questionnaireManager
        );

        parent::tearDown();
    }

    public function createQuestionnaire(): Questionnaire
    {
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();

        return $questionnaire;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $questionnaire = $this->createQuestionnaire();

        $crawler = $this->client->request('GET', '/admin/questionnaire/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Questionnaires")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is enabled")')->count() > 0
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
            $crawler->filter('td:contains("'.$questionnaire->getUuid().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();

        $crawler = $this->client->request(
            'GET',
            '/admin/questionnaire/new'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a questionnaire")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $title = 'test title';
        $crawler = $this->client->submitForm('Save', [
            'questionnaire[title]' => $title,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$title.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $questionnaire = $this->createQuestionnaire();

        $crawler = $this->client->request(
            'GET',
            '/admin/questionnaire/'.$questionnaire->getUuid()
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
            $crawler->filter('td:contains("'.$questionnaire->getUuid().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $questionnaire = $this->createQuestionnaire();

        $crawler = $this->client->request(
            'GET',
            '/admin/questionnaire/'.$questionnaire->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a questionnaire")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );

        $title = 'test title';
        $crawler = $this->client->submitForm('Update', [
            'questionnaire[title]' => $title,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$title.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $questionnaire = $this->createQuestionnaire();

        $crawler = $this->client->request(
            'GET',
            '/admin/questionnaire/'.$questionnaire->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Questionnaires")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $questionnaire = $this->createQuestionnaire();
        $this->questionnaireManager->softDelete($questionnaire, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/questionnaire/'.$questionnaire->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Questionnaires")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$questionnaire->getUuid().'")')->count() > 0
        );
    }
}
