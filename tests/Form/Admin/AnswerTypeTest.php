<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Entity\Answer;
use App\Enum\AnswerTypeEnum;
use App\Form\Admin\AnswerType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
final class AnswerTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new Answer();
        $form = $this->factory->create(AnswerType::class, $model);
        $expected = new Answer();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new Answer();
        $view = $this->factory->create(AnswerType::class, $formData)
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
                    'content' => 'test content',
                    'isEnabled' => true,
                    'position' => 1,
                    'type' => AnswerTypeEnum::DEFINED->value,
                ],
            ],
        ];
    }
}
