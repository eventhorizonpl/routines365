<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Promotion;
use App\Faker\PromotionFaker;
use App\Manager\PromotionManager;
use App\Tests\AbstractUiTestCase;

final class PromotionControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;
    /**
     * @inject
     */
    private ?PromotionManager $promotionManager;

    protected function tearDown(): void
    {
        unset(
            $this->promotionFaker,
            $this->promotionManager
        );

        parent::tearDown();
    }

    public function createPromotion(): Promotion
    {
        $promotion = $this->promotionFaker->createPromotionPersisted();

        return $promotion;
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $promotion = $this->createPromotion();

        $crawler = $this->client->request('GET', '/admin/promotion/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div', 'Promotions');
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Code")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Type")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is enabled")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Browser notifications")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email notifications")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Sms notifications")')->count() > 0
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
            $crawler->filter('td:contains("'.$promotion->getUuid().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();

        $crawler = $this->client->request(
            'GET',
            '/admin/promotion/new'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a promotion")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Code")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
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
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $name = 'test name';
        $code = 'test code';
        $description = 'test description';
        $crawler = $this->client->submitForm('Save', [
            'promotion[name]' => $name,
            'promotion[code]' => $code,
            'promotion[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$description.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $promotion = $this->createPromotion();

        $crawler = $this->client->request(
            'GET',
            '/admin/promotion/'.$promotion->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('a:contains("Basic")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('a:contains("Additional")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$promotion->getUuid().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $promotion = $this->createPromotion();

        $crawler = $this->client->request(
            'GET',
            '/admin/promotion/'.$promotion->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a promotion")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Name")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Code")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Description")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is enabled")')->count() > 0
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
        $this->assertTrue(
            $crawler->filter('label:contains("Type")')->count() > 0
        );

        $name = 'test name';
        $code = 'test code';
        $description = 'test description';
        $crawler = $this->client->submitForm('Update', [
            'promotion[name]' => $name,
            'promotion[code]' => $code,
            'promotion[description]' => $description,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$name.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$description.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $promotion = $this->createPromotion();

        $crawler = $this->client->request(
            'GET',
            '/admin/promotion/'.$promotion->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Promotions")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $promotion = $this->createPromotion();
        $this->promotionManager->softDelete($promotion, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/promotion/'.$promotion->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Promotions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$promotion->getUuid().'")')->count() > 0
        );
    }
}
