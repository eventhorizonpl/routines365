<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Testimonial;
use Symfony\Component\Uid\Uuid;

class TestimonialFactory
{
    public function createTestimonial(): Testimonial
    {
        $testimonial = new Testimonial();
        $testimonial->setUuid((string) Uuid::v4());

        return $testimonial;
    }

    public function createTestimonialWithRequired(
        string $content,
        bool $isVisible,
        string $signature
    ): Testimonial {
        $testimonial = $this->createTestimonial();

        $testimonial
            ->setContent($content)
            ->setIsVisible($isVisible)
            ->setSignature($signature)
        ;

        return $testimonial;
    }
}
