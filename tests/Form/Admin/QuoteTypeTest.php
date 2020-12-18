<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Entity\Quote;
use App\Form\Admin\QuoteType;
use Symfony\Component\Form\Test\TypeTestCase;

final class QuoteTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData)
    {
        $model = new Quote();
        $form = $this->factory->create(QuoteType::class, $model);
        $expected = new Quote();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView()
    {
        $formData = new Quote();
        $view = $this->factory->create(QuoteType::class, $formData)
            ->createView();
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'author' => 'test author',
                    'content' => 'test content',
                    'isVisible' => true,
                ],
            ],
        ];
    }
}
