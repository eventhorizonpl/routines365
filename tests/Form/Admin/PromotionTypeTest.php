<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Entity\Promotion;
use App\Form\Admin\PromotionType;
use Symfony\Component\Form\Test\TypeTestCase;

final class PromotionTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData)
    {
        $model = new Promotion();
        $form = $this->factory->create(PromotionType::class, $model);
        $expected = new Promotion();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView()
    {
        $formData = new Promotion();
        $view = $this->factory->create(PromotionType::class, $formData)
            ->createView();
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'code' => 'test code',
                    'description' => 'test description',
                    'emailNotifications' => 10,
                    'isEnabled' => true,
                    'name' => 'test name',
                    'smsNotifications' => 10,
                    'type' => Promotion::TYPE_EXISTING_ACCOUNT,
                ],
            ],
        ];
    }
}
