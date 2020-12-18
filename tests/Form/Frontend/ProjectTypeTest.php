<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Entity\Project;
use App\Form\Frontend\ProjectType;
use Symfony\Component\Form\Test\TypeTestCase;

final class ProjectTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData)
    {
        $model = new Project();
        $form = $this->factory->create(ProjectType::class, $model);
        $expected = new Project();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView()
    {
        $formData = new Project();
        $view = $this->factory->create(ProjectType::class, $formData)
            ->createView();
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'description' => 'test description',
                    'name' => 'test name',
                    'isCompleted' => false,
                ],
            ],
        ];
    }
}
