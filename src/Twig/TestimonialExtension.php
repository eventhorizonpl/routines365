<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Testimonial;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TestimonialExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('testimonialStatus', [$this, 'testimonialStatus']),
        ];
    }

    public function testimonialStatus(): array
    {
        return Testimonial::getStatusFormChoices();
    }
}
