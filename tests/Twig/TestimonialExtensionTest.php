<?php

declare(strict_types=1);

namespace App\Tests\Twig;

use App\Tests\AbstractTestCase;
use App\Twig\TestimonialExtension;

/**
 * @internal
 * @coversNothing
 */
final class TestimonialExtensionTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $testimonialExtension = new TestimonialExtension();

        $this->assertInstanceOf(TestimonialExtension::class, $testimonialExtension);
    }

    public function testGetFunctions(): void
    {
        $testimonialExtension = new TestimonialExtension();

        $this->assertCount(1, $testimonialExtension->getFunctions());
        $this->assertIsArray($testimonialExtension->getFunctions());
    }

    public function testTestimonialStatus(): void
    {
        $testimonialExtension = new TestimonialExtension();

        $this->assertCount(3, $testimonialExtension->testimonialStatus());
        $this->assertIsArray($testimonialExtension->testimonialStatus());
    }
}
