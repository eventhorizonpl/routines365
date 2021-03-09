<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\AccountOperation;
use App\Manager\AccountOperationManager;
use App\Tests\AbstractUiTestCase;

final class AccountOperationControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?AccountOperationManager $accountOperationManager;

    protected function tearDown(): void
    {
        unset($this->accountOperationManager);

        parent::tearDown();
    }

    public function createAccountOperation(): AccountOperation
    {
        $user = $this->userFaker->createRichUserPersisted();
        $accountOperation = $user->getAccount()->getAccountOperations()->first();

        return $accountOperation;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $accountOperation = $this->createAccountOperation();

        $crawler = $this->client->request('GET', '/admin/account-operation/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Account operations")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Notifications")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Sms notifications")')->count() > 0
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
            $crawler->filter('td:contains("'.$accountOperation->getUuid().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $accountOperation = $this->createAccountOperation();

        $crawler = $this->client->request(
            'GET',
            '/admin/account-operation/'.$accountOperation->getUuid()
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
            $crawler->filter('td:contains("'.$accountOperation->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $accountOperation = $this->createAccountOperation();
        $this->accountOperationManager->softDelete($accountOperation, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/account-operation/'.$accountOperation->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Account operations")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$accountOperation->getUuid().'")')->count() > 0
        );
    }

    public function testAddFreeEmail(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $accountOperation = $this->createAccountOperation();

        $crawler = $this->client->request(
            'GET',
            '/admin/account-operation/'.$accountOperation->getAccount()->getUuid().'/add-free-email'
        );

        $this->assertResponseIsSuccessful();
    }

    public function testAddFreeSms(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $accountOperation = $this->createAccountOperation();

        $crawler = $this->client->request(
            'GET',
            '/admin/account-operation/'.$accountOperation->getAccount()->getUuid().'/add-free-sms'
        );

        $this->assertResponseIsSuccessful();
    }
}
