<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\UserQuestionnaire;
use App\Faker\QuestionnaireFaker;
use App\Faker\UserQuestionnaireFaker;
use App\Manager\UserQuestionnaireManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class UserQuestionnaireControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?QuestionnaireFaker $questionnaireFaker;
    /**
     * @inject
     */
    private ?UserQuestionnaireFaker $userQuestionnaireFaker;
    /**
     * @inject
     */
    private ?UserQuestionnaireManager $userQuestionnaireManager;

    protected function tearDown(): void
    {
        $this->questionnaireFaker = null;
        $this->userQuestionnaireFaker = null;
        $this->userQuestionnaireManager = null
        ;

        parent::tearDown();
    }

    public function createUserQuestionnaire(): UserQuestionnaire
    {
        $user = $this->userFaker->createRichUserPersisted();
        $questionnaire = $this->questionnaireFaker->createRichQuestionnairePersisted();

        return $this->userQuestionnaireFaker->createUserQuestionnairePersisted($user, $questionnaire);
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $userQuestionnaire = $this->createUserQuestionnaire();

        $crawler = $this->client->request('GET', '/admin/user-questionnaire/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Users questionnaires")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Questionnaire")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is completed")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is rewarded")')->count() > 0
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
            $crawler->filter('td:contains("'.$userQuestionnaire->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$userQuestionnaire->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $userQuestionnaire = $this->createUserQuestionnaire();

        $crawler = $this->client->request(
            'GET',
            '/admin/user-questionnaire/'.$userQuestionnaire->getUuid()
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
            $crawler->filter('td:contains("'.$userQuestionnaire->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $userQuestionnaire = $this->createUserQuestionnaire();
        $this->userQuestionnaireManager->softDelete($userQuestionnaire, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/user-questionnaire/'.$userQuestionnaire->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Users questionnaires")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$userQuestionnaire->getUuid().'")')->count() > 0
        );
    }
}
