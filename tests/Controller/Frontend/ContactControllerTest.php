<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

final class ContactControllerTest extends AbstractUiTestCase
{
    public function testNew(): void
    {
        $this->purge();
        $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/contact/new');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Contact form")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );

        $crawler = $this->client->submitForm('Send');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $crawler = $this->client->submitForm('Send', [
            'contact[title]' => 'test title',
            'contact[content]' => 'test content',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We saved your contact request. We will get back to you soon.")')->count() > 0
        );
    }
}
