<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Quote;
use App\Faker\QuoteFaker;
use App\Manager\QuoteManager;
use App\Tests\AbstractUiTestCase;

final class QuoteControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?QuoteFaker $quoteFaker;
    /**
     * @inject
     */
    private ?QuoteManager $quoteManager;

    protected function tearDown(): void
    {
        unset(
            $this->quoteFaker,
            $this->quoteManager
        );

        parent::tearDown();
    }

    public function createQuote(): Quote
    {
        $quote = $this->quoteFaker->createQuotePersisted();

        return $quote;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $quote = $this->createQuote();

        $crawler = $this->client->request('GET', '/admin/quote/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Quotes")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Author")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Content")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is visible")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("String length")')->count() > 0
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
            $crawler->filter('td:contains("'.$quote->getUuid().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();

        $crawler = $this->client->request(
            'GET',
            '/admin/quote/new'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a quote")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Author")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is visible")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $author = 'test author';
        $content = 'test content';
        $crawler = $this->client->submitForm('Save', [
            'quote[author]' => $author,
            'quote[content]' => $content,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$author.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$content.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $quote = $this->createQuote();

        $crawler = $this->client->request(
            'GET',
            '/admin/quote/'.$quote->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$quote->getUuid().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $quote = $this->createQuote();

        $crawler = $this->client->request(
            'GET',
            '/admin/quote/'.$quote->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a quote")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Author")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is visible")')->count() > 0
        );

        $author = 'test author';
        $content = 'test content';
        $crawler = $this->client->submitForm('Update', [
            'quote[author]' => $author,
            'quote[content]' => $content,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$author.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$content.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $quote = $this->createQuote();

        $crawler = $this->client->request(
            'GET',
            '/admin/quote/'.$quote->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Quotes")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $quote = $this->createQuote();
        $this->quoteManager->softDelete($quote, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/quote/'.$quote->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Quotes")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$quote->getUuid().'")')->count() > 0
        );
    }
}
