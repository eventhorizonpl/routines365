<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Manager\UserManager;
use App\Repository\UserRepository;
use App\Tests\AbstractUiTestCase;

final class UserControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?UserManager $userManager;
    /**
     * @inject
     */
    private ?UserRepository $userRepository;

    protected function tearDown(): void
    {
        unset(
            $this->userManager,
            $this->userRepository
        );

        parent::tearDown();
    }

    public function createUser(): User
    {
        $user = $this->userFaker->createUserPersisted();

        return $user;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $user = $this->createUser();

        $crawler = $this->client->request('GET', '/admin/user/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'Users');
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is verified")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Roles")')->count() > 0
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
            $crawler->filter('td:contains("'.$user->getUuid().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();

        $crawler = $this->client->request(
            'GET',
            '/admin/user/new'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create an user")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Send weekly monthly statistics")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Show motivational messages")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Theme")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Time zone")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Repeat Password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Roles")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is verified")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $email = 'test@example.org';
        $password = 'test password';
        $crawler = $this->client->submitForm('Save', [
            'user[email]' => $email,
            'user[plainPassword][first]' => $password,
            'user[plainPassword][second]' => $password,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$email.'")')->count() > 0
        );
    }

    public function testNewLead(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();

        $crawler = $this->client->request(
            'GET',
            '/admin/user/new-lead'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a lead")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Send weekly monthly statistics")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Show motivational messages")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Theme")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Time zone")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Browser notifications")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Email notifications")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Sms notifications")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $email = 'test@example.org';
        $crawler = $this->client->submitForm('Save', [
            'user_lead[email]' => $email,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$email.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $user = $this->createUser();

        $crawler = $this->client->request(
            'GET',
            '/admin/user/'.$user->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Relations")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional account details")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional profile details")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional user KYT details")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional user details")')->count() > 0
        );

        $this->assertTrue(
            $crawler->filter('td:contains("'.$user->getUuid().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $user = $this->createUser();

        $crawler = $this->client->request(
            'GET',
            '/admin/user/'.$user->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit an user")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Send weekly monthly statistics")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Show motivational messages")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Theme")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Time zone")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Repeat Password")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Roles")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is verified")')->count() > 0
        );

        $email = 'test@example.org';
        $password = 'test password';
        $crawler = $this->client->submitForm('Update', [
            'user[email]' => $email,
            'user[plainPassword][first]' => $password,
            'user[plainPassword][second]' => $password,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$email.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $user = $this->createUser();

        $crawler = $this->client->request(
            'GET',
            '/admin/user/'.$user->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Users")')->count() > 0
        );
    }

    public function testDisable2fa(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $user = $this->createUser();
        $user->setGoogleAuthenticatorSecret('test google authenticator secret');
        $userId = $user->getId();

        $crawler = $this->client->request(
            'GET',
            '/admin/user/'.$user->getUuid().'/disable-2fa'
        );

        $this->assertResponseIsSuccessful();

        $this->entityManager->clear();
        $user2 = $this->userRepository->findOneById($userId);
        $this->assertInstanceOf(User::class, $user2);
        $this->assertNull($user2->getGoogleAuthenticatorSecret());
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $user = $this->createUser();
        $this->userManager->softDelete($user, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/user/'.$user->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Users")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$user->getUuid().'")')->count() > 0
        );
    }
}
