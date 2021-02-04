<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Tests\AbstractUiTestCase;

final class WorkspaceControllerTest extends AbstractUiTestCase
{
    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();

        $crawler = $this->client->request('GET', '/admin/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'Workspace');
        $this->assertTrue(
            $crawler->filter('td:contains("Accounts")')->count() > 0
        );
    }
}
