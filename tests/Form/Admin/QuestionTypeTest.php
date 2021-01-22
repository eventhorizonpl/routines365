<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Entity\Question;
use App\Form\Admin\QuestionType;
use Symfony\Component\Form\Test\TypeTestCase;

final class QuestionTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new Question();
        $form = $this->factory->create(QuestionType::class, $model);
        $expected = new Question();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new Question();
        $view = $this->factory->create(QuestionType::class, $formData)
            ->createView();
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'isEnabled' => true,
                    'position' => 1,
                    'title' => 'test title',
                    'type' => Question::TYPE_SINGLE_ANSWER,
                ],
            ],
        ];
    }
}