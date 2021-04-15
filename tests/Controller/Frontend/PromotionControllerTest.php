<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Faker\PromotionFaker;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class PromotionControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;

    protected function tearDown(): void
    {
        $this->promotionFaker = null
        ;

        parent::tearDown();
    }

    public function testCode(): void
    {
        $this->purge();
        $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted();

        $crawler = $this->client->request('GET', '/promotions');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Promotion codes")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Promotion code")')->count() > 0
        );

        $crawler = $this->client->submitForm('Use promotion code');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $crawler = $this->client->submitForm('Use promotion code', [
            'promotion_code[code]' => 'WRONG CODE',
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("You cannot use this promotion code.")')->count() > 0
        );

        $crawler = $this->client->submitForm('Use promotion code', [
            'promotion_code[code]' => $promotion->getCode(),
        ]);

        $this->assertResponseIsSuccessful();
    }
}
