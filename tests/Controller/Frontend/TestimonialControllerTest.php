<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Tests\AbstractUiTestCase;

final class TestimonialControllerTest extends AbstractUiTestCase
{
    public function testNew(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

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

        $crawler = $this->client->request('GET', '/testimonial/new');

        $this->assertResponseIsSuccessful();
    }
}
