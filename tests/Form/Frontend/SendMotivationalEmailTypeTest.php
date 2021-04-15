<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Form\Frontend\SendMotivationalEmailType;
use App\Form\Model\SendMotivationalEmailFormModel;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
final class SendMotivationalEmailTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new SendMotivationalEmailFormModel();
        $form = $this->factory->create(SendMotivationalEmailType::class, $model);
        $expected = new SendMotivationalEmailFormModel();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new SendMotivationalEmailFormModel();
        $view = $this->factory->create(SendMotivationalEmailType::class, $formData)
            ->createView()
        ;
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'email' => 'a@b.com',
                ],
            ],
        ];
    }
}
