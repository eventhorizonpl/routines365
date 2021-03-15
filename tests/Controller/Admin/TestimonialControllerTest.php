<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Entity\Testimonial;
use App\Manager\TestimonialManager;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class TestimonialControllerTest extends AbstractUiTestCase
{
    /**
     * @inject
     */
    private ?TestimonialManager $testimonialManager;

    protected function tearDown(): void
    {
        $this->testimonialManager = null
        ;

        parent::tearDown();
    }

    public function createTestimonial(): Testimonial
    {
        $user = $this->userFaker->createRichUserPersisted();

        return $user->getTestimonial();
    }

    public function testIndex(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $testimonial = $this->createTestimonial();

        $crawler = $this->client->request('GET', '/admin/testimonial/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("Testimonials")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("UUID")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Email")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Content")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Signature")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Status")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Is visible")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Updated at")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('th:contains("Actions")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$testimonial->getUuid().'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $testimonial = $this->createTestimonial();

        $crawler = $this->client->request(
            'GET',
            '/admin/testimonial/'.$testimonial->getUuid()
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
            $crawler->filter('td:contains("'.$testimonial->getUuid().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $this->createAndLoginAdmin();
        $testimonial = $this->createTestimonial();

        $crawler = $this->client->request(
            'GET',
            '/admin/testimonial/'.$testimonial->getUuid().'/edit'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a testimonial")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Signature")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Status")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Is visible")')->count() > 0
        );

        $content = 'test content';
        $signature = 'test signature';
        $crawler = $this->client->submitForm('Update', [
            'testimonial[content]' => $content,
            'testimonial[signature]' => $signature,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$content.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$signature.'")')->count() > 0
        );
    }

    public function testUndelete(): void
    {
        $this->purge();
        $admin = $this->createAndLoginAdmin();
        $testimonial = $this->createTestimonial();
        $this->testimonialManager->softDelete($testimonial, (string) $admin);

        $crawler = $this->client->request(
            'GET',
            '/admin/testimonial/'.$testimonial->getUuid().'/undelete'
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Testimonials")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('td:contains("'.$testimonial->getUuid().'")')->count() > 0
        );
    }
}
