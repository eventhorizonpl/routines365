<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\{Promotion, Testimonial};
use App\Faker\PromotionFaker;
use App\Manager\UserManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 */
final class TestimonialControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?PromotionFaker $promotionFaker;
    /**
     * @inject
     */
    private ?UserManager $userManager;

    protected function tearDown(): void
    {
        $this->promotionFaker = null;
        $this->userManager = null
        ;

        parent::tearDown();
    }

    public function testNew(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();
        $promotion = $this->promotionFaker->createPromotionPersisted('REWARD10', true, null, null, null, Promotion::TYPE_SYSTEM);

        $crawler = $this->client->request('GET', '/testimonial/new');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Testimonial")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Signature")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save', [
            'testimonial[content]' => 'test content',
            'testimonial[signature]' => 'test signature',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("We saved your testimonial.")')->count() > 0
        );

        $this->entityManager->refresh($user);
        $user->getTestimonial()->setStatus(Testimonial::STATUS_ACCEPTED);
        $this->userManager->save($user);

        $crawler = $this->client->request('GET', '/testimonial/new');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("We already accepted your testimonial.")')->count() > 0
        );
    }
}
