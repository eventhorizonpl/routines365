<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Entity\Testimonial;
use App\Form\Admin\TestimonialType;
use Symfony\Component\Form\Test\TypeTestCase;

final class TestimonialTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new Testimonial();
        $form = $this->factory->create(TestimonialType::class, $model);
        $expected = new Testimonial();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new Testimonial();
        $view = $this->factory->create(TestimonialType::class, $formData)
            ->createView();
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'content' => 'test comment',
                    'signature' => 'test content',
                    'isVisible' => true,
                    'status' => Testimonial::STATUS_NEW,
                ],
            ],
        ];
    }
}
