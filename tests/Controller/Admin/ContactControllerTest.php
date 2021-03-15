<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Contact;
use App\Manager\ContactManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class ContactControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?ContactManager $contactManager;

    protected function tearDown(): void
    {
        $this->contactManager = null
        ;

        parent::tearDown();
    }

    public function createContact(): Contact
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getContacts()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $contact = $this->createContact();

        $crawler = $this->client->request('GET', '/admin/contact/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Contacts")')->count() > 0
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
            $crawler->filter('th:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Status")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Updated at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$contact->getUuid().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $contact = $this->createContact();

        $crawler = $this->client->request(
            'GET',
            '/admin/contact/'.$contact->getUuid()
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
            $crawler->filter('td:contains("'.$contact->getUuid().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $contact = $this->createContact();

        $crawler = $this->client->request(
            'GET',
            '/admin/contact/'.$contact->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a contact")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Comment")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Status")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );

        $title = 'test title';
        $crawler = $this->client->submitForm('Update', [
            'contact[title]' => $title,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$title.'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $contact = $this->createContact();
        $this->contactManager->softDelete($contact, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/contact/'.$contact->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Contacts")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$contact->getUuid().'")')->count() > 0
        );
    }
}
