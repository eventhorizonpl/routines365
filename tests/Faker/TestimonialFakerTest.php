<?php

declare(strict_types=1);

namespace App\Tests\Faker;

use App\Entity\Testimonial;
use App\Factory\TestimonialFactory;
use App\Faker\TestimonialFaker;
use App\Manager\TestimonialManager;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class TestimonialFakerTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?TestimonialFactory $testimonialFactory;
    /**
     * @inject
     */
    private ?TestimonialFaker $testimonialFaker;
    /**
     * @inject
     */
    private ?TestimonialManager $testimonialManager;

    protected function tearDown(): void
    {
        $this->testimonialFactory = null;
        $this->testimonialFaker = null;
        $this->testimonialManager = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $testimonialFaker = new TestimonialFaker($this->testimonialFactory, $this->testimonialManager);

        $this->assertInstanceOf(TestimonialFaker::class, $testimonialFaker);
    }

    public function testCreateTestimonial(): void
    {
        $this->purge();
        $testimonial = $this->testimonialFaker->createTestimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial);
        $content = 'test content';
        $isVisible = true;
        $signature = 'test signature';
        $testimonial = $this->testimonialFaker->createTestimonial(
            $content,
            $isVisible,
            $signature
        );
        $this->assertSame($content, $testimonial->getContent());
        $this->assertSame($isVisible, $testimonial->getIsVisible());
        $this->assertSame($signature, $testimonial->getSignature());
    }
}
