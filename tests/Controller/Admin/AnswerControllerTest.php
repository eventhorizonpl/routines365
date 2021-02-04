<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Faker\QuestionnaireFaker;
use App\Manager\AnswerManager;
use App\Tests\AbstractUiTestCase;

final class AnswerControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?AnswerManager $answerManager;

    protected function tearDown(): void
    {
        unset(
            $this->questionnaireFaker,
            $this->answerManager
        );

        parent::tearDown();
    }

    public function createAnswer(): Answer
    {
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();
        $answer = $questionnaire->getQuestions()->first()->getAnswers()->first();

        return $answer;
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
        $question = $this->createQuestion();

        $crawler = $this->client->request(
            'GET',
            '/admin/answer/new/'.$question->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create an answer")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
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

        $content = 'test content';
        $crawler = $this->client->submitForm('Save', [
            'answer[content]' => $content,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$content.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $answer = $this->createAnswer();

        $crawler = $this->client->request(
            'GET',
            '/admin/answer/'.$answer->getUuid()
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
            $crawler->filter('td:contains("'.$answer->getUuid().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $answer = $this->createAnswer();

        $crawler = $this->client->request(
            'GET',
            '/admin/answer/'.$answer->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit an answer")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
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

        $content = 'test content';
        $crawler = $this->client->submitForm('Update', [
            'answer[content]' => $content,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$content.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $answer = $this->createAnswer();

        $crawler = $this->client->request(
            'GET',
            '/admin/answer/'.$answer->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('h5:contains("Answers")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $answer = $this->createAnswer();
        $this->answerManager->softDelete($answer, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/answer/'.$answer->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('td:contains("'.$answer->getUuid().'")')->count() > 0
        );
    }
}
