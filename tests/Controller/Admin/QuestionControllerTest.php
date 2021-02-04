<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Faker\QuestionnaireFaker;
use App\Manager\QuestionManager;
use App\Tests\AbstractUiTestCase;

final class QuestionControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?QuestionManager $questionManager;

    protected function tearDown(): void
    {
        unset(
            $this->questionnaireFaker,
            $this->questionManager
        );

        parent::tearDown();
    }

    public function createQuestion(): Question
    {
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $question = $questionnaire->getQuestions()->first();

        return $question;
    }

    public function createQuestionnaire(): Questionnaire
    {
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();

        return $questionnaire;
    }

    public function testNew(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $questionnaire = $this->createQuestionnaire();

        $crawler = $this->client->request(
            'GET',
            '/admin/question/new/'.$questionnaire->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a question")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Position")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
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
            'question[title]' => $title,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('th:contains("'.$title.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $question = $this->createQuestion();

        $crawler = $this->client->request(
            'GET',
            '/admin/question/'.$question->getUuid()
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
            $crawler->filter('td:contains("'.$question->getUuid().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $question = $this->createQuestion();

        $crawler = $this->client->request(
            'GET',
            '/admin/question/'.$question->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a question")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Position")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );

        $title = 'test title';
        $crawler = $this->client->submitForm('Update', [
            'question[title]' => $title,
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
        $question = $this->createQuestion();

        $crawler = $this->client->request(
            'GET',
            '/admin/question/'.$question->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('h5:contains("Questions")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $question = $this->createQuestion();
        $this->questionManager->softDelete($question, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/question/'.$question->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('td:contains("'.$question->getUuid().'")')->count() > 0
        );
    }
}
