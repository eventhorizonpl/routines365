<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Testimonial;
use App\Factory\TestimonialFactory;
use App\Tests\AbstractTestCase;
use Faker\Factory;
use Faker\Generator;

final class TestimonialFactoryTest extends AbstractTestCase
{
    private ?Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    protected function tearDown(): void
    {
        unset($this->faker);

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $testimonialFactory = new TestimonialFactory();

        $this->assertInstanceOf(TestimonialFactory::class, $testimonialFactory);
    }

    public function testCreateTestimonial(): void
    {
        $testimonialFactory = new TestimonialFactory();
        $testimonial = $testimonialFactory->createTestimonial();
        $this->assertInstanceOf(Testimonial::class, $testimonial);
    }

    public function testCreateTestimonialWithRequired(): void
    {
        $content = $this->faker->sentence;
        $isVisible = $this->faker->boolean;
        $signature = $this->faker->sentence;
        $testimonialFactory = new TestimonialFactory();
        $testimonial = $testimonialFactory->createTestimonialWithRequired(
            $content,
            $isVisible,
            $signature
        );
        $this->assertInstanceOf(Testimonial::class, $testimonial);
        $this->assertEquals($content, $testimonial->getContent());
        $this->assertEquals($isVisible, $testimonial->getIsVisible());
        $this->assertEquals($signature, $testimonial->getSignature());
    }
}
