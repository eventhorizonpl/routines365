<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Form\Frontend\PromotionCodeType;
use App\Form\Model\PromotionCodeFormModel;
use Symfony\Component\Form\Test\TypeTestCase;

final class PromotionCodeTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData)
    {
        $model = new PromotionCodeFormModel();
        $form = $this->factory->create(PromotionCodeType::class, $model);
        $expected = new PromotionCodeFormModel();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView()
    {
        $formData = new PromotionCodeFormModel();
        $view = $this->factory->create(PromotionCodeType::class, $formData)
            ->createView();
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'code' => 'TEST123',
                ],
            ],
        ];
    }
}
