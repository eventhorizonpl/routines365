<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Note;
use App\Manager\NoteManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class NoteControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?NoteManager $noteManager;

    protected function tearDown(): void
    {
        $this->noteManager = null;

        parent::tearDown();
    }

    public function createNote(): Note
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getNotes()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $note = $this->createNote();

        $crawler = $this->client->request('GET', '/admin/note/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Notes")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Content")')->count() > 0
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
            $crawler->filter('td:contains("'.$note->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$note->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $note = $this->createNote();

        $crawler = $this->client->request(
            'GET',
            '/admin/note/'.$note->getUuid()
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
            $crawler->filter('td:contains("'.$note->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $note = $this->createNote();
        $this->noteManager->softDelete($note, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/note/'.$note->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Notes")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$note->getUuid().'")')->count() > 0
        );
    }
}
