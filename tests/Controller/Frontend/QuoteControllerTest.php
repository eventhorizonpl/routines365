<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Faker\QuoteFaker;
use App\Tests\AbstractUiTestCase;

final class QuoteControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;

    protected function tearDown(): void
    {
        unset(
            $this->quoteFaker,
        );

        parent::tearDown();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginRegular();
        $quote = $this->quoteFaker->createQuotePersisted(null, null, true);

        $crawler = $this->client->request('GET', '/motivate-friend');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Motivate a friend")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$quote->getContent().'")')->count() > 0
        );
    }

    public function testSend(): void
    {
        $this->purge();
        $this->createAndLoginRegular();
        $quote = $this->quoteFaker->createQuotePersisted(null, null, true);

        $crawler = $this->client->request('GET', '/motivate-friend/'.$quote->getUuid().'/send');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Edit profile")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("First name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Last name")')->count() > 0
        );

        $crawler = $this->client->submitForm('Update', [
            'profile[firstName]' => 'John',
            'profile[lastName]' => 'Doe',
        ]);

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->request('GET', '/motivate-friend/'.$quote->getUuid().'/send');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Send a motivational email to a friend")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Email")')->count() > 0
        );

        $crawler = $this->client->submitForm('Send', [
            'send_motivational_email[email]' => 'test@example.org',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Email was sent. You can send motivational message to another person.")')->count() > 0
        );
    }
}
