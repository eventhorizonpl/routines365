<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\SavedEmail;
use App\Manager\SavedEmailManager;
use App\Tests\AbstractUiTestCase;

final class SavedEmailControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?SavedEmailManager $savedEmailManager;

    protected function tearDown(): void
    {
        unset($this->savedEmailManager);

        parent::tearDown();
    }

    public function createSavedEmail(): SavedEmail
    {
        $user = $this->userFaker->createRichUserPersisted();
        $savedEmail = $user->getSavedEmails()->first();

        return $savedEmail;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $savedEmail = $this->createSavedEmail();

        $crawler = $this->client->request('GET', '/admin/saved-email/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'Saved emails');
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Saved email")')->count() > 0
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
            $crawler->filter('td:contains("'.$savedEmail->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$savedEmail->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $savedEmail = $this->createSavedEmail();

        $crawler = $this->client->request(
            'GET',
            '/admin/saved-email/'.$savedEmail->getUuid()
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
            $crawler->filter('td:contains("'.$savedEmail->getUuid().'")')->count() > 0
        );
    }
}
