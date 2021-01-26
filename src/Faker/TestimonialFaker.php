<?php

declare(strict_types=1);

namespace App\Faker;

use App\Entity\Testimonial;
use App\Factory\TestimonialFactory;
use App\Manager\TestimonialManager;
use Faker\Factory;
use Faker\Generator;

class TestimonialFaker
{
    private Generator $faker;
    private TestimonialFactory $testimonialFactory;
    private TestimonialManager $testimonialManager;

    public function __construct(
        TestimonialFactory $testimonialFactory,
        TestimonialManager $testimonialManager
    ) {
        $this->faker = Factory::create();
        $this->testimonialFactory = $testimonialFactory;
        $this->testimonialManager = $testimonialManager;
    }

    public function createTestimonial(
        ?string $content = null,
        ?bool $isVisible = null,
        ?string $signature = null
    ): Testimonial {
        if (null === $content) {
            $content = (string) $this->faker->text;
        }

        if (null === $isVisible) {
            $isVisible = (bool) $this->faker->boolean;
        }

        if (null === $signature) {
            $signature = (string) $this->faker->name;
        }

        $testimonial = $this->testimonialFactory->createTestimonialWithRequired(
            $content,
            $isVisible,
            $signature
        );

        return $testimonial;
    }
}
