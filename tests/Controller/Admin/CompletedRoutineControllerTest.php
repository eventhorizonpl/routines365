<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\CompletedRoutine;
use App\Manager\CompletedRoutineManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class CompletedRoutineControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?CompletedRoutineManager $completedRoutineManager;

    protected function tearDown(): void
    {
        $this->completedRoutineManager = null;

        parent::tearDown();
    }

    public function createCompletedRoutine(): CompletedRoutine
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getCompletedRoutines()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $completedRoutine = $this->createCompletedRoutine();

        $crawler = $this->client->request('GET', '/admin/completed-routine/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Completed routines")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Comment")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Minutes devoted")')->count() > 0
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
            $crawler->filter('td:contains("'.$completedRoutine->getUuid().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$completedRoutine->getUser()->getEmail().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $completedRoutine = $this->createCompletedRoutine();

        $crawler = $this->client->request(
            'GET',
            '/admin/completed-routine/'.$completedRoutine->getUuid()
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
            $crawler->filter('td:contains("'.$completedRoutine->getUuid().'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $completedRoutine = $this->createCompletedRoutine();
        $this->completedRoutineManager->softDelete($completedRoutine, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/completed-routine/'.$completedRoutine->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Completed routines")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$completedRoutine->getUuid().'")')->count() > 0
        );
    }
}
