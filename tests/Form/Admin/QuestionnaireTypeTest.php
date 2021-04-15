<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Entity\Questionnaire;
use App\Form\Admin\QuestionnaireType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
final class QuestionnaireTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new Questionnaire();
        $form = $this->factory->create(QuestionnaireType::class, $model);
        $expected = new Questionnaire();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new Questionnaire();
        $view = $this->factory->create(QuestionnaireType::class, $formData)
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
                    'isEnabled' => true,
                    'title' => 'test title',
                    'description' => 'test description',
                ],
            ],
        ];
    }
}
